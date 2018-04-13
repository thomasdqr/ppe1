using System;
using System.Collections.Generic;
using System.Collections.Specialized;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.IO;
using System.Linq;
using System.Net;
using System.Security.Cryptography;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Xml.Linq;

namespace GSBDesktop
{
    public partial class Form1 : Form
    {
        public static int id_comptable;
        public Form1()
        {
            InitializeComponent();
        }

        static string Hash(string input)
        {
            using (SHA1Managed sha1 = new SHA1Managed())
            {
                var hash = sha1.ComputeHash(Encoding.UTF8.GetBytes(input));
                var sb = new StringBuilder(hash.Length * 2);

                foreach (byte b in hash)
                {
                    // can be "x2" if you want lowercase
                    sb.Append(b.ToString("x2"));
                }

                return sb.ToString();
            }
        }

        private void button1_Click(object sender, EventArgs e)
        {
            Int32 unixTimestamp = (Int32)(DateTime.UtcNow.Subtract(new DateTime(1970, 1, 1))).TotalSeconds;
            String hash = Hash("1" + unixTimestamp.ToString() + "legrascestlavie") + "_" + unixTimestamp.ToString();
            String sMonth = DateTime.Now.ToString("MM");
            String sYear = DateTime.Now.ToString("YYYY");

            NameValueCollection postValues = new NameValueCollection();
            postValues["id_user"] = "1";
            postValues["hash"] = hash;
            postValues["action"] = "connect_comptable";
            postValues["month"] = sMonth;
            postValues["year"] = sYear;
            postValues["username"] = textBox1.Text;
            postValues["password"] = textBox2.Text;

            WebClient webClient = new WebClient();
            webClient.UploadValuesCompleted += webClient_UploadValuesCompleted;
            webClient.Proxy = null; // Accélère la communication
            webClient.UploadValuesAsync(new Uri("https://thomasdequeiros.fr/GSB/communicate.php"), "POST", postValues);


        }

        void webClient_UploadValuesCompleted(object sender, System.Net.UploadValuesCompletedEventArgs e)
        {
            string reponse = Encoding.UTF8.GetString(e.Result);
            if (reponse.Split(';')[0] == "chevalierisation")
            {
                id_comptable = Int32.Parse(reponse.Split(';')[1]);
                Form myform = new Form2();
                myform.Show();
                this.Hide();
            }
            else
            {
                MessageBox.Show(reponse);
            }
            
        }
    }
}
