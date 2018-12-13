using FirebirdSql.Data.FirebirdClient;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace WindowsFormsApp1
{
    public partial class Form1 : Form
    {



        public Form1()
        {
            InitializeComponent();
        }



        private void buttonOK_Click(object sender, EventArgs e)
        {


            #region oop exkurs 
            /*
           Auto auto = new Auto("grün");
           Auto auto2 = new Auto("blau");

           List<Auto> alleAutos = new List<Auto>();
           alleAutos.Add(auto);
           alleAutos.Add(auto2);

           Auto a = alleAutos[1];

           MessageBox.Show(a.Farbe);


           //MessageBox.Show("Farbe Auto 1: " + auto.Farbe);
           //MessageBox.Show("Farbe Auto 2: " +  auto2.Farbe);


           for (int i = 0; i < 50; i++)
           {
               if (i % 3 == 0)
                   auto.Beschleunigen(5);
               else
                   auto2.Beschleunigen(5);
           }



           //MessageBox.Show("Geschw. Auto 1: " + auto.AktuelleGeschwindigkeit);
           //MessageBox.Show("Geschw Auto 2: " + auto2.AktuelleGeschwindigkeit);


           return;
           */
            #endregion

            comboTables.Items.Clear();


            string connectionString =
                @"User =SYSDBA;" +
                @"Password=masterkey;" +
                @"Database=C:\xampp\htdocs\Projekt-BLJ\src\FirebirdTest\TADATA.FDB;" +
                @"ServerType=1";

            FbConnection con = new FbConnection(connectionString);
            con.Open();

            DataTable t = con.GetSchema("Tables");
            DataTable dt = new DataTable();
            FbCommand cmd = new FbCommand();
            cmd.Connection = con;

            FbDataAdapter adap = new FbDataAdapter();
            adap.SelectCommand = cmd;

            
            //AddTableDataToGrid("schedules", cmd, adap);
            //AddTableDataToGrid("ATTENDANT", cmd, adap);
            //AddTableDataToGrid("DEPARTMENTS", cmd, adap);
            //AddTableDataToGrid("DEVICES", cmd, adap);
            //AddTableDataToGrid("EXTRATIME", cmd, adap);
            //AddTableDataToGrid("IDENTIFICATION", cmd, adap);
            //AddTableDataToGrid("PAYCLASS", cmd, adap);
            //AddTableDataToGrid("PAYRULE", cmd, adap);
            //AddTableDataToGrid("PLANNING", cmd, adap);
            AddTableDataToGrid("USERS", cmd, adap);
            //AddTableDataToGrid("WORKCODES", cmd, adap);

            //GetTableDataToDatabase("USERS", cmd, adap);

            /*
            FbCommand cmd2 = new FbCommand("Update users set password = ''");
            cmd2.Connection = con;
            int affectedRecords = cmd2.ExecuteNonQuery();
            */

            con.Close();
        }

        private void dataGridView1_DataError(object sender, DataGridViewDataErrorEventArgs e)
        {

        }

        private void comboTables_SelectedIndexChanged(object sender, EventArgs e)
        {
            dataGridView1.DataSource = null;


            if (comboTables.SelectedIndex > -1)
            {
                dataGridView1.DataSource = (comboTables.SelectedItem as ComboBoxItem).Data;
            }
        }

        private void AddTableDataToGrid(string tableName, FbCommand cmd, FbDataAdapter adap)
        {
            DataTable dt = new DataTable();
            cmd.CommandText = "select * from " + tableName;
            adap.Fill(dt);
            dt.TableName = tableName;
            comboTables.Items.Add(new ComboBoxItem(dt.Copy()));

            List<User> users = new List<User>();

            foreach (DataRow row in dt.Rows)
            {
                User u = new User();
                u.Firstname = row["firstname"].ToString();
                u.ID = Convert.ToInt32(row["ID"]);
                users.Add(u);
            }

           foreach (User u in users)
                MessageBox.Show(u.Firstname);
        }
        //private void GetTableDataToDatabase(string tableName, FbCommand cmd, FbDataAdapter adap)
        //{
        //    int id = 0;
        //    string username;
        //    string firstname;
        //    string lastname;
        //    DataTable dt = new DataTable();
        //    cmd.CommandText = "select ID from " + tableName + "where ID 29";
        //    adap.Fill(dt);
        //    dt.TableName = tableName;
        //    comboTables.Items.Add(new ComboBoxItem(dt.Copy()));

        //}

    }
}
