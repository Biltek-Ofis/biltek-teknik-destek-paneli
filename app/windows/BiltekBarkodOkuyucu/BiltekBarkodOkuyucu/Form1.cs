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
					
					source = new CancellationTokenSource();
					while (true)
					{
						TcpClient Client = await Listener.AcceptTcpClientAsync();
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
										bool status = int.TryParse(""+SB, out int servisNo);
										if (status)
										{
											System.Diagnostics.Process.Start("https://teknikservis.biltekbilgisayar.com.tr/?servisNo=" + SB);
										}
										else
										{
											if(""+SB == "eslesti")
											{
												pictureBox1.Image = Properties.Resources._checked;
											}
										}
									}
									catch (Exception ex)
									{
										Console.WriteLine(ex.ToString());
									}
								}
							}
							else
							{
								if (source.Token.IsCancellationRequested)
								{
									Client.Close();
									break;
								}
							}
						}
						catch (Exception Ex)
						{
							Console.WriteLine(Ex.ToString());
						}
						Client.Close();
					}

					Invoke(new Action(() =>
					{
						lblDesc.Text = "Barkod Okuma Etkin Değil";
					}));
					if (Listener.Active)
						Listener.Stop();
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
