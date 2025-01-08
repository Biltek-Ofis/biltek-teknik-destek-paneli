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
				btnBaslat.Enabled = false;
				if (btnBaslat.Text == "Başlat")
				{
					Task.Run(async () =>
					{
						Invoke(new Action(() =>
						{
							btnBaslat.Text = "Durdur";
							lblDesc.Text = "Barkod Okuma Bekleniyor";
							btnBaslat.Enabled = true;
						}));
						await RunServer();
					});
				}
				else
				{
					source.Cancel();
				}
			}
			catch (Exception ex)
			{
				source.Cancel();
				lblIP.Text = "";
				lblPort.Text = "";
				btnBaslat.Text = "Baslat";
				lblDesc.Text = "Bilgisayar Herhangi bir internete bağlı değil.";
				btnBaslat.Enabled = true;
				Console.WriteLine("2: " + ex.Message);
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
					while (!source.Token.IsCancellationRequested)
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
						btnBaslat.Text = "Baslat";
						btnBaslat.Enabled = true;
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
						btnBaslat.Text = "Baslat";
						btnBaslat.Enabled = true;
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
			}
			BaslangicaEkle();
			Baslat();
		}

		private void BaslangicaEkle()
		{
			RegistryKey rk = Registry.CurrentUser.OpenSubKey
				("SOFTWARE\\Microsoft\\Windows\\CurrentVersion\\Run", true);

			//if (chkStartUp.Checked)
				rk.SetValue(Name, Application.ExecutablePath);
			/*else
				rk.DeleteValue(Name, false);*/
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
	}
}
