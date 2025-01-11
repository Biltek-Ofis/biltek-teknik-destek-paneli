using System;
using System.Net.Sockets;
using System.Net;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Threading;
using Microsoft.Win32;
using System.Drawing;
using ZXing.QrCode;
using ZXing;
using System.Linq;

namespace BiltekBarkodOkuyucu
{
    public partial class Form1 : Form
    {
		bool forceClose = false;
        public Form1()
        {
            InitializeComponent();
			Icon = notifyIcon1.Icon = Properties.Resources.app_icon;
		}
		int port = 9200;

		CancellationTokenSource source = new CancellationTokenSource();
		private void btnBaslat_Click(object sender, EventArgs e)
        {
			Baslat();
        }
		private void Baslat()
		{
			try
			{
				Task.Run(async () =>
				{
					await RunServer();
				});
			}
			catch (Exception ex)
			{
				lblIP.Text = "";
				lblPort.Text = "";
				lblDesc.Text = "Bilgisayar Herhangi bir internete bağlı değil.";
				Console.WriteLine(ex.Message);
			}
		}
		async Task RunServer()
        {
			string ip = GetLocalIPAddress();
			TcpListenerEx Listener = new TcpListenerEx(IPAddress.Any, port);
			if (!string.IsNullOrEmpty(ip))
			{
				try
				{
					if (Listener.Active)
						Listener.Stop();
					Listener.Start();
					TcpClient client;
					source = new CancellationTokenSource();
					while (true)
					{
						client = await Listener.AcceptTcpClientAsync();
						ThreadPool.QueueUserWorkItem(ThreadProc, client);
						
					}
				}
				catch (Exception Ex)
				{
					Console.WriteLine(Ex.ToString());
					source.Cancel();
					Invoke(new Action(() =>
					{
						lblDesc.Text = "Barkod Okuma Etkin Değil";
					}));
					if (Listener.Active)
						Listener.Stop();
				}
			}
			else
			{
				Invoke(new Action(() =>
				{
					lblIP.Text = "";
					lblPort.Text = "";
					lblDesc.Text = "Bilgisayar Herhangi bir internete bağlı değil.";
				}));
				if (Listener.Active)
					Listener.Stop();
			}
			
        }

		private void ThreadProc(object state)
		{
			var Client = (TcpClient)state;
			while (Client.Connected)
			{
				try
				{
					var Stream = Client.GetStream();
					if (Stream.CanRead)
					{
						byte[] Buffer = new byte[Client.ReceiveBufferSize];

						StringBuilder SB = new StringBuilder();
						do
						{
							int BytesReaded = Stream.Read(Buffer, 0, Buffer.Length);
							SB.AppendFormat("{0}", Encoding.ASCII.GetString(Buffer, 0, BytesReaded));
							if (source.Token.IsCancellationRequested)
							{
								Client.Close();
								break;
							}
						} while (Stream.DataAvailable);

						if (SB != null)
						{
							try
							{
								string gelen = "" + SB;
								if (string.IsNullOrEmpty(gelen))
									continue;
								Console.WriteLine("Gelen Mesaj: " + gelen);
								if (gelen.ToLower() == "eslesti")
								{
									pictureBox1.Image = Properties.Resources._checked;
								}
								else
								{
									try
									{
										var bolum = gelen.Split(new[] { ':' }, 2);
										if (bolum.Length == 2)
										{
											Console.WriteLine("Bölüm 1: " + bolum[0]);
											Console.WriteLine("Bölüm 2: " + bolum[1]);
											switch (bolum[0].ToLower())
											{
												case "servisno":
													bool status = int.TryParse(bolum[1], out int servisNo);
													if (status)
													{
														Console.WriteLine("Servis No açılıyor");
														System.Diagnostics.Process.Start("https://teknikservis.biltekbilgisayar.com.tr/?servisNo=" + servisNo);
													}
													else
													{
														throw new Exception("Servis No Hatalı");
													}
													break;
												case "cmd":
													System.Diagnostics.Process process = new System.Diagnostics.Process();
													System.Diagnostics.ProcessStartInfo info = new System.Diagnostics.ProcessStartInfo();
													info.FileName = "cmd.exe";
													info.Arguments = "/C " + bolum[1];

													process.StartInfo = info;
													process.Start();
													
													break;
												default:
													throw new Exception("Önceden Tanımlanmamış");
											}
										}
										else
										{
											Console.WriteLine("Mesaj İşlenmedi.");
										}
									}
									catch (Exception ex)
									{
										Console.WriteLine("Mesaj İşleme Hatası: " + ex.ToString());
									}
								}
							}
							catch (Exception ex)
							{
								Console.WriteLine(ex.ToString());
							}
						}
					}
				}
				catch (Exception Ex)
				{
					Console.WriteLine(Ex.ToString());
				}
			}
			
		    Client.Close();
		}

		private void Form1_Load(object sender, EventArgs e)
		{
			string ip = GetLocalIPAddress();
			if (string.IsNullOrEmpty(ip))
			{
				lblIP.Text = "Bilgisayar Herhangi bir internete bağlı değil.";
				lblPort.Text = "";
			}
			else
			{
				lblIP.Text = "IP: "+ip;
				lblPort.Text = "Port: "+ port.ToString();
				QrYenile(ip, port);
			}
			if (Properties.Settings.Default.ilkAcilis)
			{
				BaslangicDurumu(true);
				Properties.Settings.Default.ilkAcilis = false;
				Properties.Settings.Default.Save();
			}

			RegistryKey rk = Registry.CurrentUser.OpenSubKey(reg, true);
			string baslangicDurumu = (string)rk.GetValue(Text, null);
			checkBox1.Checked = !string.IsNullOrEmpty(baslangicDurumu);
			Baslat();
		}
		string reg = "SOFTWARE\\Microsoft\\Windows\\CurrentVersion\\Run";
		private void BaslangicDurumu(bool durum)
		{
			try
			{
				RegistryKey rk = Registry.CurrentUser.OpenSubKey(reg, true);
				if (durum)
					rk.SetValue(Text, Application.ExecutablePath);
				else
					rk.DeleteValue(Text, false);
			}
			catch (Exception ex)
			{
				Console.WriteLine(ex.ToString());
			}
		}

		public static string GetLocalIPAddress()
		{
			var host = Dns.GetHostEntry(Dns.GetHostName());
			foreach (var ip in host.AddressList)
			{
				if (ip.AddressFamily == AddressFamily.InterNetwork)
				{
					return ip.ToString();
				}
			}
			return null;

		}

		private void Form1_FormClosing(object sender, FormClosingEventArgs e)
		{
			if (!forceClose)
			{
				notifyIcon1.Visible = true;
				this.Hide();
				e.Cancel = true;
			}
		}

		private void notifyIcon1_DoubleClick(object sender, EventArgs e)
		{
			gosterToolStripMenuItem_Click(sender, e);
		}

		private void notifyIcon1_MouseDoubleClick(object sender, MouseEventArgs e)
		{
			gosterToolStripMenuItem_Click(sender, e);
		}

		private void gosterToolStripMenuItem_Click(object sender, EventArgs e)
		{
			if (Visible)
				Hide();
			else
				Show();
		}

		private void kapatToolStripMenuItem_Click(object sender, EventArgs e)
		{
			forceClose = true;
			Close();
		}

		private void btnQrYenile_Click(object sender, EventArgs e)
		{
			string ip = GetLocalIPAddress();
			if (!string.IsNullOrEmpty(ip))
				QrYenile(ip, port);
			else
				MessageBox.Show("Local IP Adresiniz bulunamadi. Lütfen bir ağa bağlandığınıza emin olun.");
		}


		private void QrYenile(string ip, int port)
		{
			btnQrYenile.Enabled = false;
			string text = ip + ":" + port.ToString();
			QrCodeEncodingOptions options = new QrCodeEncodingOptions()
			{
				DisableECI = true,
				CharacterSet = "UTF-8",
				Width = 100,
				Height = 100
			};

			BarcodeWriter writer = new BarcodeWriter()
			{
				Format = BarcodeFormat.QR_CODE,
				Options = options
			};
			Bitmap qrCodeBitmap = writer.Write(text);
			pictureBox1.Image = qrCodeBitmap;
			btnQrYenile.Visible = true; 
			btnQrYenile.Enabled = true;
		}

		private void checkBox1_CheckedChanged(object sender, EventArgs e)
		{
			BaslangicDurumu(checkBox1.Checked);
		}
	}
}
