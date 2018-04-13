using System;
using System.Collections.Generic;
using System.Collections.Specialized;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Net;
using System.Security.Cryptography;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace GSBDesktop
{
    public partial class Form2 : Form
    {
        List<string> visiteurs_id = new List<string>();
        List<string> period_id = new List<string>();
        int hf_number = 0;

        public Form2()
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

        private void Form2_Load(object sender, EventArgs e)
        {
            Int32 unixTimestamp = (Int32)(DateTime.UtcNow.Subtract(new DateTime(1970, 1, 1))).TotalSeconds;
            String hash = Hash(Form1.id_comptable + unixTimestamp.ToString() + "legrascestlavie") + "_" + unixTimestamp.ToString();
            String sMonth = DateTime.Now.ToString("MM");
            String sYear = DateTime.Now.ToString("YYYY");

            NameValueCollection postValues = new NameValueCollection();
            postValues["action"] = "get_visiteurs";
            postValues["id_user"] = Form1.id_comptable.ToString();
            postValues["hash"] = hash;
            postValues["month"] = sMonth;
            postValues["year"] = sYear;

            WebClient webClient = new WebClient();
            webClient.UploadValuesCompleted += webClient_UploadValuesCompleted;
            webClient.Proxy = null; // Accélère la communication
            webClient.UploadValuesAsync(new Uri("https://thomasdequeiros.fr/GSB/communicate.php"), "POST", postValues);
        }

        void webClient_UploadValuesCompleted(object sender, System.Net.UploadValuesCompletedEventArgs e)
        {
            comboBox1.Items.Clear();
            visiteurs_id.Clear();
            string reponse = Encoding.UTF8.GetString(e.Result);
            foreach (string line in reponse.Split('|')) {
                if (line.Length > 1)
                {
                    comboBox1.Items.Add(line.Split(';')[1]);
                    visiteurs_id.Add(line.Split(';')[0]);  
                }
                
            }

        }

        void webClient_UploadValuesCompleted2(object sender, System.Net.UploadValuesCompletedEventArgs e)
        {
            string reponse = Encoding.UTF8.GetString(e.Result); 
            comboBox2.Items.Clear();
            foreach (string line in reponse.Split('|'))
            {
                if (line.Length > 1)
                {
                    comboBox2.Items.Add(line.Split(';')[1]);
                    period_id.Add(line.Split(';')[0]);
                }

            }

        }

        void webClient_UploadValuesCompleted3(object sender, System.Net.UploadValuesCompletedEventArgs e)
        {
            string reponse = Encoding.UTF8.GetString(e.Result);
            textBox1.Text = reponse.Split(';')[2];
            textBox2.Text = reponse.Split(';')[1];
            textBox3.Text = reponse.Split(';')[0];
            if (reponse.Split(';')[3] == "0")
            {
                button1.Enabled = true;
                button2.Enabled = false;
            }
            if (reponse.Split(';')[3] == "1")
            {
                button1.Enabled = true;
                button2.Enabled = true;
            }
            if (reponse.Split(';')[3] == "2")
            {
                button1.Enabled = false;
                button2.Enabled = false;
            }
        }

        void webClient_UploadValuesCompleted4(object sender, System.Net.UploadValuesCompletedEventArgs e)
        {
            dataGridView1.Rows.Clear();
            string reponse = Encoding.UTF8.GetString(e.Result);
            List<String> hf = new List<string>();
            hf = reponse.Split('|').ToList();
            hf_number = 0;
            //int index = 0;
            foreach (String hf_data in hf)
            {
                if (hf_data.Length > 1)
                {
                    hf_number += 1;
                    if (hf_data.Split(';')[5] == "0")
                    {
                        dataGridView1.Rows.Add(hf_data.Split(';')[3], hf_data.Split(';')[0], hf_data.Split(';')[1], hf_data.Split(';')[2], hf_data.Split(';')[4], "traitement en cours", false);
                        //dataGridView1.Rows[index].Cells[5] = new DataGridViewCheckBoxCell();
                    }
                    if (hf_data.Split(';')[5] == "1")
                    {
                        dataGridView1.Rows.Add(hf_data.Split(';')[3], hf_data.Split(';')[0], hf_data.Split(';')[1], hf_data.Split(';')[2], hf_data.Split(';')[4], "validé", true);
                        //dataGridView1.Rows[index].Cells[5] = new DataGridViewCheckBoxCell();
                    }
                    if (hf_data.Split(';')[5] == "2")
                    {
                        dataGridView1.Rows.Add(hf_data.Split(';')[3], hf_data.Split(';')[0], hf_data.Split(';')[1], hf_data.Split(';')[2], hf_data.Split(';')[4], "refusé", false);
                        //dataGridView1.Rows[index].Cells[5] = new DataGridViewCheckBoxCell();
                    }
                }
                //index++;
            }

        }

        void webClient_UploadValuesCompleted5(object sender, System.Net.UploadValuesCompletedEventArgs e)
        {
            ReloadTab();
        }

            private void comboBox1_SelectedIndexChanged(object sender, EventArgs e)
        {
            //MessageBox.Show(visiteurs_id[comboBox1.SelectedIndex].ToString());

            Int32 unixTimestamp = (Int32)(DateTime.UtcNow.Subtract(new DateTime(1970, 1, 1))).TotalSeconds;
            String hash = Hash(visiteurs_id[comboBox1.SelectedIndex].ToString() + unixTimestamp.ToString() + "legrascestlavie") + "_" + unixTimestamp.ToString();
            String sMonth = DateTime.Now.ToString("MM");
            String sYear = DateTime.Now.ToString("YYYY");

            NameValueCollection postValues = new NameValueCollection();
            postValues["action"] = "get_period";
            postValues["id_user"] = visiteurs_id[comboBox1.SelectedIndex].ToString();
            postValues["hash"] = hash;
            postValues["month"] = sMonth;
            postValues["year"] = sYear;

            WebClient webClient = new WebClient();
            webClient.UploadValuesCompleted += webClient_UploadValuesCompleted2;
            webClient.Proxy = null; // Accélère la communication
            webClient.UploadValuesAsync(new Uri("https://thomasdequeiros.fr/GSB/communicate.php"), "POST", postValues);
        }

        private void comboBox2_SelectedIndexChanged(object sender, EventArgs e)
        {
            ReloadTab();
        }

        private void ReloadTab()
        {
            Int32 unixTimestamp = (Int32)(DateTime.UtcNow.Subtract(new DateTime(1970, 1, 1))).TotalSeconds;
            String hash = Hash(visiteurs_id[comboBox1.SelectedIndex].ToString() + unixTimestamp.ToString() + "legrascestlavie") + "_" + unixTimestamp.ToString();
            String sMonth = comboBox2.SelectedItem.ToString().Substring(5, 2);
            String sYear = comboBox2.SelectedItem.ToString().Substring(0, 4);

            NameValueCollection postValues = new NameValueCollection();
            postValues["action"] = "get_ff";
            postValues["id_user"] = visiteurs_id[comboBox1.SelectedIndex].ToString();
            postValues["hash"] = hash;
            postValues["month"] = sMonth;
            postValues["year"] = sYear;

            WebClient webClient = new WebClient();
            webClient.UploadValuesCompleted += webClient_UploadValuesCompleted3;
            webClient.Proxy = null; // Accélère la communication
            webClient.UploadValuesAsync(new Uri("https://thomasdequeiros.fr/GSB/communicate.php"), "POST", postValues);

            NameValueCollection postValues2 = new NameValueCollection();
            postValues2["action"] = "get_hf";
            postValues2["id_user"] = visiteurs_id[comboBox1.SelectedIndex].ToString();
            postValues2["hash"] = hash;
            postValues2["month"] = sMonth;
            postValues2["year"] = sYear;

            WebClient webClient2 = new WebClient();
            webClient2.UploadValuesCompleted += webClient_UploadValuesCompleted4;
            webClient2.Proxy = null; // Accélère la communication
            webClient2.UploadValuesAsync(new Uri("https://thomasdequeiros.fr/GSB/communicate.php"), "POST", postValues2);
        }

        private void button1_Click(object sender, EventArgs e)
        {
            for (int i = 0; i < hf_number; i++)
            {
                string id = dataGridView1.Rows[i].Cells[0].Value.ToString();
                bool val = Convert.ToBoolean(dataGridView1.Rows[i].Cells[6].Value);
                string status = "";
                if (val)
                {
                    status = "1";
                }
                else
                {
                    status = "2";
                }
                
                Int32 unixTimestamp = (Int32)(DateTime.UtcNow.Subtract(new DateTime(1970, 1, 1))).TotalSeconds;
                String hash = Hash(visiteurs_id[comboBox1.SelectedIndex].ToString() + unixTimestamp.ToString() + "legrascestlavie") + "_" + unixTimestamp.ToString();
                String sMonth = DateTime.Now.ToString("MM");
                String sYear = DateTime.Now.ToString("YYYY");

                NameValueCollection postValues = new NameValueCollection();
                postValues["id_user"] = visiteurs_id[comboBox1.SelectedIndex].ToString();
                postValues["hash"] = hash;
                postValues["action"] = "validate_hf";
                postValues["month"] = sMonth;
                postValues["year"] = sYear;
                postValues["id_hf"] = id;
                postValues["status"] = status;
                postValues["id_comptable"] = Form1.id_comptable.ToString();
                WebClient webClient = new WebClient();
                webClient.Proxy = null; // Accélère la communication
                webClient.UploadValuesAsync(new Uri("https://thomasdequeiros.fr/GSB/communicate.php"), "POST", postValues);  
            }

            Int32 unixTimestamp2 = (Int32)(DateTime.UtcNow.Subtract(new DateTime(1970, 1, 1))).TotalSeconds;
            String hash2 = Hash(visiteurs_id[comboBox1.SelectedIndex].ToString() + unixTimestamp2.ToString() + "legrascestlavie") + "_" + unixTimestamp2.ToString();
            String sMonth2 = DateTime.Parse(comboBox2.SelectedItem.ToString()).ToString("MM");
            String sYear2 = DateTime.Parse(comboBox2.SelectedItem.ToString()).Year.ToString();

            NameValueCollection postValues2 = new NameValueCollection();
            postValues2["id_user"] = visiteurs_id[comboBox1.SelectedIndex].ToString();
            postValues2["hash"] = hash2;
            postValues2["action"] = "forfait";
            postValues2["month"] = sMonth2;
            postValues2["year"] = sYear2;
            postValues2["nuits"] = textBox3.Text;
            postValues2["repas"] = textBox2.Text;
            postValues2["km"] = textBox1.Text;
            postValues2["id_comptable"] = Form1.id_comptable.ToString();
            postValues2["status"] = "1";
            WebClient webClient2 = new WebClient();
            webClient2.Proxy = null; // Accélère la communication
            webClient2.UploadValuesAsync(new Uri("https://thomasdequeiros.fr/GSB/communicate.php"), "POST", postValues2);

            Int32 unixTimestamp3 = (Int32)(DateTime.UtcNow.Subtract(new DateTime(1970, 1, 1))).TotalSeconds;
            String hash3 = Hash(visiteurs_id[comboBox1.SelectedIndex].ToString() + unixTimestamp2.ToString() + "legrascestlavie") + "_" + unixTimestamp2.ToString();
            String sMonth3 = DateTime.Parse(comboBox2.SelectedItem.ToString()).ToString("MM");
            String sYear3 = DateTime.Parse(comboBox2.SelectedItem.ToString()).Year.ToString();

            NameValueCollection postValues3 = new NameValueCollection();
            postValues3["id_user"] = visiteurs_id[comboBox1.SelectedIndex].ToString();
            postValues3["hash"] = hash3;
            postValues3["action"] = "change_status";
            postValues3["month"] = sMonth3;
            postValues3["year"] = sYear3;
            postValues3["id_comptable"] = Form1.id_comptable.ToString();
            postValues3["status"] = "1";
            MessageBox.Show(Form1.id_comptable.ToString());
            WebClient webClient3 = new WebClient();
            webClient3.UploadValuesCompleted += webClient_UploadValuesCompleted5;
            webClient3.Proxy = null; // Accélère la communication
            webClient3.UploadValuesAsync(new Uri("https://thomasdequeiros.fr/GSB/communicate.php"), "POST", postValues3);
        }

        private void button2_Click(object sender, EventArgs e)
        {
            // Mise en paiement
            Int32 unixTimestamp3 = (Int32)(DateTime.UtcNow.Subtract(new DateTime(1970, 1, 1))).TotalSeconds;
            String hash3 = Hash(visiteurs_id[comboBox1.SelectedIndex].ToString() + unixTimestamp3.ToString() + "legrascestlavie") + "_" + unixTimestamp3.ToString();
            String sMonth3 = DateTime.Parse(comboBox2.SelectedItem.ToString()).ToString("MM");
            String sYear3 = DateTime.Parse(comboBox2.SelectedItem.ToString()).Year.ToString();

            NameValueCollection postValues3 = new NameValueCollection();
            postValues3["id_user"] = visiteurs_id[comboBox1.SelectedIndex].ToString();
            postValues3["hash"] = hash3;
            postValues3["action"] = "change_status";
            postValues3["month"] = sMonth3;
            postValues3["year"] = sYear3;
            postValues3["status"] = "2";
            WebClient webClient3 = new WebClient();
            webClient3.UploadValuesCompleted += webClient_UploadValuesCompleted5;
            webClient3.Proxy = null; // Accélère la communication
            webClient3.UploadValuesAsync(new Uri("https://thomasdequeiros.fr/GSB/communicate.php"), "POST", postValues3);
        }
    }
}
