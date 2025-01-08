using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace BiltekBarkodOkuyucu
{
    internal static class Program
    {
        /// <summary>
        /// Uygulamanın ana girdi noktası.
        /// </summary>
        [STAThread]
        static void Main()
        {
			bool result;
			var mutex = new System.Threading.Mutex(true, "{9e626b71-bf04-40a1-b6c3-cb785729aa24}", out result);

			if (!result)
			{
				MessageBox.Show("Uygulama zaten çalışıyor", "Biltek Barkod Okuyucu");
				return;
			}

			Application.EnableVisualStyles();
			Application.SetCompatibleTextRenderingDefault(false);
			Application.Run(new Form1());

			GC.KeepAlive(mutex);
        }
    }
}
