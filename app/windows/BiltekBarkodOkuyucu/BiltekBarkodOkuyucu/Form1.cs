using System;
using System.Net.Sockets;
using System.Net;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Threading;

namespace BiltekBarkodOkuyucu
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }
        CancellationTokenSource source = new CancellationTokenSource();
        
        private void btnBaslat_Click(object sender, EventArgs e)
        {
            btnBaslat.Enabled = false;
            if(btnBaslat.Text == "Başlat")
            {
                Task.Run(async () =>
                {
                    Invoke(new Action(() =>
                    {
                        btnBaslat.Text = "Durdur";
                        btnBaslat.Enabled = true;
                    }));
                    await RunServer();
                });
            }
            else
            {
                source.Cancel();
                btnBaslat.Text = "Başlat";
                btnBaslat.Enabled = true;
            }
        }
         async Task RunServer()
        {
            TcpListener Listener = new TcpListener(IPAddress.Any, 9201); // Set your listener
            Listener.Start(); // Start your listener
            CancellationToken token = source.Token;
            token.Register(Listener.Stop);
            while (!token.IsCancellationRequested) // Permanent loop, it may not be the best solution
            {
                TcpClient Client = await Listener.AcceptTcpClientAsync(); // Waiting for a connection
                try
                {
                    var Stream = Client.GetStream(); // (read-only) get data bytes
                    if (Stream.CanRead) // Verify if the stream can be read.
                    {
                        byte[] Buffer = new byte[Client.ReceiveBufferSize]; // Initialize a new empty byte array with the data length.
                        StringBuilder SB = new StringBuilder();
                        do // Start converting bytes to string
                        {
                            int BytesReaded = Stream.Read(Buffer, 0, Buffer.Length);
                            SB.AppendFormat("{0}", Encoding.ASCII.GetString(Buffer, 0, BytesReaded));
                        } while (Stream.DataAvailable); // Until stream data is available

                        if (SB != null)
                        {
                            System.Diagnostics.Process.Start("http://localhost/?servisNo=" + SB);
                        }
                    }
                }
                catch (Exception Ex) // In case of errors catch it to avoid the app crash
                {
                    Console.WriteLine(Ex.ToString()); // Detailed exception
                }
            }
        }
    }
}
