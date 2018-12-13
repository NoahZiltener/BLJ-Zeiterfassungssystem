using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Data.OleDb;
using FirebirdSql.Data.FirebirdClient;
using System.Data;
using MySql.Data;
using MySql.Data.MySqlClient;

namespace datatransfer
{
    class Program
    {
        
        static void Main(string[] args)
        {
            string connectionString =
                  @"User =SYSDBA;" +
                  @"Password=masterkey;" +
                  @"Database=C:\xampp\htdocs\Projekt-BLJ\src\TADATA.FDB;" +
                  @"ServerType=1";

            FbConnection con = new FbConnection(connectionString);
            con.Open();

            DataTable tab = con.GetSchema("Tables");
            DataTable dtu = new DataTable();
            DataTable dtt = new DataTable();
            FbCommand cmd = new FbCommand();
            cmd.Connection = con;

            FbDataAdapter adap = new FbDataAdapter();
            adap.SelectCommand = cmd;

            cmd.CommandText = "select * from USERS" ;
            adap.Fill(dtu);
            cmd.CommandText = "select * from ATTENDANT";
            adap.Fill(dtt);

            List<User> users = new List<User>();
            insertUserToList(dtu, users);

            List<Time> times = new List<Time>();
            insertTimeToList(dtt, times);



            //Ausgabe der Daten
            foreach (User u in users)
            {
                Console.WriteLine("User ID: " + u.ID);
                Console.WriteLine("User Vorname: " + u.Firstname);
                Console.WriteLine("User Nachname: " + u.Lastname);
                Console.WriteLine("User Username: " + u.Username + "\n");
            }
            foreach (Time t in times)
            {
                Console.WriteLine("Zeit ID: " + t.ID);
                Console.WriteLine("User ID: " + t.UserID);
                Console.WriteLine("INOUT: " + t.InOut);
                Console.WriteLine("Zeit: " + t.time + "\n");
            }
            Console.ReadKey();
        }
        static void insertUserToList(DataTable dt, List<User> users)
        {
            foreach (DataRow row in dt.Rows)
            {
                User u = new User();
                u.ID = Convert.ToInt32(row["ID"]);
                u.Firstname = row["firstname"].ToString();
                u.Lastname = row["lastname"].ToString();
                u.Username = row["username"].ToString();
                users.Add(u);
            }
        }
        static void insertTimeToList(DataTable dt, List<Time> times)
        {
            foreach(DataRow row in dt.Rows)
            {
                Stamp s = new Stamp();
                s.ID = Convert.ToInt32(row["ID"]);
                s.DateAndTime = Convert.ToDateTime(row["WHEN"]);
                s.Remark = row["UPDATEREMARK"].ToString();
                s.Workcode = row["WORKCODE"].ToString();
                //Morgen weitermachen
                //if(row[""])
                //s.IsIgnored = row["UPDATEREMARK"].ToString();
                s.UserID = Convert.ToInt32(row["USERID"]);
            }
            
        }
    }
    
}
