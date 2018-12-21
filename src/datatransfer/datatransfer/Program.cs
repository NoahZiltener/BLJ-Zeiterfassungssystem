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
            FbCommand cmdfd = new FbCommand();
            cmdfd.Connection = con;

            FbDataAdapter adap = new FbDataAdapter();
            adap.SelectCommand = cmdfd;

            cmdfd.CommandText = "select * from USERS" ;
            adap.Fill(dtu);
            cmdfd.CommandText = "select * from ATTENDANT order by \"WHEN\" asc";
            adap.Fill(dtt);

            List<User> allusers = new List<User>();
            List<Stamp> allstamps = new List<Stamp>();
            List<Day> allDays = new List<Day>();

            CreateUser(dtu, allusers);
            CreateStamp(dtt, allstamps);
            CreateDay(allstamps, allDays);

            Console.WriteLine("Getting Connection ...");
            MySqlConnection conn = DBUtils.GetDBConnection();

            try
            {
                Console.WriteLine("Openning Connection ...");

                conn.Open();

                Console.WriteLine("Connection successful!");
            }
            catch (Exception e)
            {
                Console.WriteLine("Error: " + e.Message);
            }

            //InsertUsersInToDB(conn, allusers);
            //InsertStampsInToDB(conn, allstamps);
            //InsertDaysInToDB(conn, allDays);
            Console.WriteLine("successful!");

            //Ausgabe der Daten
            //foreach (User u in allusers)
            //{
            //    Console.WriteLine("User ID: " + u.ID);
            //    Console.WriteLine("User Vorname: " + u.Firstname);
            //    Console.WriteLine("User Nachname: " + u.Lastname);
            //    Console.WriteLine("User Username: " + u.Username + "\n");
            //}
            //foreach (Stamp t in allstamps)
            //{
            //    Console.WriteLine("Zeit ID: " + t.ID);
            //    Console.WriteLine("User ID: " + t.UserID);
            //    Console.WriteLine("DateAndTime: " + t.DateAndTime);
            //    Console.WriteLine("Workcode: " + t.Workcode);
            //    Console.WriteLine("Remark: " + t.Remark);
            //    Console.WriteLine("IsIgnored: " + t.IsIgnored + "\n");
            //}
            foreach (Day d in allDays)
            {
                Console.WriteLine("UserID: " + d.UserID);
                Console.WriteLine("Zeiten: ");
                foreach (Stamp stamp in d.Stamps)
                {
                    if (stamp.IsIgnored != true)
                    {
                        Console.WriteLine(stamp.DateAndTime);
                    }
                }
                Console.WriteLine("DateOfDay: " + d.DateOfDay);
                Console.WriteLine("worktime: " + d.worktime.TotalHours);
                Console.WriteLine("lunchtime: " + d.lunchtime.TotalHours);
                Console.WriteLine("overtime: " + d.overtime);
                Console.WriteLine("TimeOfDay: " + d.TimeOfDay.TotalHours);
                Console.WriteLine("IsValid: " + d.IsValid + "\n");
            }
            Console.ReadKey();
        }
        static void CreateUser(DataTable dt, List<User> users)
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
        static void CreateStamp(DataTable dt, List<Stamp> stamps)
        {
            foreach(DataRow row in dt.Rows)
            {
                Stamp s = new Stamp();
                s.ID = Convert.ToInt32(row["ID"]);
                s.UserID = Convert.ToInt32(row["USERID"]);
                s.DateAndTime = Convert.ToDateTime(row["WHEN"]);
                s.Remark = row["UPDATEREMARK"].ToString();
                s.Workcode = Convert.ToInt32(row["WORKCODE"]);
                if (row["UPDATEINOUT"] != DBNull.Value && Convert.ToInt32(row["UPDATEINOUT"]) == 4)
                {
                    s.IsIgnored = true;
                }
                else
                {
                    s.IsIgnored = false;
                }
                stamps.Add(s);
                if (row["updatewhen"] != DBNull.Value)
                {
                   s.UpdateDate = Convert.ToDateTime(row["updatewhen"]);
                   s.UpdateUserID = Convert.ToInt32(row["UPDATEUSERID"]);
                }
                else if(row["updatechangewhen"] != DBNull.Value)
                {
                    s.UpdateDate = Convert.ToDateTime(row["updatechangewhen"]);
                    s.UpdateUserID = Convert.ToInt32(row["UPDATEUSERID"]);
                }
                
            }
            
        }
        static void CreateDay(List<Stamp> stamps, List<Day> days)
        {
            foreach(Stamp stamp in stamps)
            {

                IEnumerable<Day> founddays =
                    from day in days
                    where day.UserID == stamp.UserID && stamp.DateAndTime.Date == day.DateOfDay
                    select day;
    
                if (founddays.Count() > 0 && stamp.IsIgnored != true)
                {
                    founddays.First().Stamps.Add(stamp);
                      
                }
                else if (stamp.IsIgnored != true)
                {
                    Day d = new Day(stamp.DateAndTime, stamp.UserID);
                    d.Stamps.Add(stamp);
                    days.Add(d);
                }
            }
            foreach (Day d in days)
            {
                d.IsValid = d.IsValidDay();
                if(d.IsValid == true)
                {
                    d.TimeOfDay = d.GetTimeOfDay();
                    d.worktime = d.GetWorkTime();
                    d.lunchtime = d.Getlunchtime();
                    d.overtime = d.GetOverTime();
                }
            }
            


        }
        static void InsertUsersInToDB(MySqlConnection conn, List<User> allusers)
        {
            foreach(User u in allusers)
            {
                try
                {
                    string sql = "Insert into users (UserID, UserEMail, UserPassword, UserFirstName, UserLastName, UserName)"
                                    + " values (@UserID, @UserEMail, @UserPassword, @UserFirstName, @UserLastName, @UserName) ";
                    MySqlCommand cmd = conn.CreateCommand();
                    cmd.CommandText = sql; 

                    MySqlParameter UserIDParam = new MySqlParameter("@UserID", MySqlDbType.Int32);
                    UserIDParam.Value = u.ID;
                    cmd.Parameters.Add(UserIDParam);

                    MySqlParameter UserEMailParam = new MySqlParameter("@UserEMail", MySqlDbType.VarChar);
                    UserEMailParam.Value = "keine Email vorhanden";
                    cmd.Parameters.Add(UserEMailParam);

                    MySqlParameter UserPasswordParam = new MySqlParameter("@UserPassword", MySqlDbType.VarChar);
                    UserPasswordParam.Value = "$2y$10$qCgb4MKzbMKAqUU2LOFBQ.wGoAD6yBElFA7V7EPwK.QGCViJjx4mu";
                    cmd.Parameters.Add(UserPasswordParam);

                    MySqlParameter UserFirstNameParam = new MySqlParameter("@UserFirstName", MySqlDbType.VarChar);
                    UserFirstNameParam.Value = u.Firstname;
                    cmd.Parameters.Add(UserFirstNameParam);

                    MySqlParameter UserLastNameParam = new MySqlParameter("@UserLastName", MySqlDbType.VarChar);
                    UserLastNameParam.Value = u.Lastname;
                    cmd.Parameters.Add(UserLastNameParam);

                    MySqlParameter UserNameParam = new MySqlParameter("@UserName", MySqlDbType.VarChar);
                    UserNameParam.Value = u.Username;
                    cmd.Parameters.Add(UserNameParam);

                    cmd.ExecuteNonQuery();
                }
                catch (Exception e)
                {
                    Console.WriteLine("Error: " + e);
                    Console.WriteLine(e.StackTrace);
                }
            }
            
        }
        static void InsertStampsInToDB(MySqlConnection conn, List<Stamp> allstamps)
        {
            foreach (Stamp s in allstamps)
            {
                try
                {
                    string sql = "Insert into stamps (StampID, StampDateandTime, StampRemark,IsIgnored, StampWorkcode, UserID)"
                                    + " values (@StampID, @StampDateandTime, @StampRemark,@IsIgnored, @StampWorkcode, @UserID) ";
                    MySqlCommand cmd = conn.CreateCommand();
                    cmd.CommandText = sql;

                    MySqlParameter StampIDParam = new MySqlParameter("@StampID", MySqlDbType.Int32);
                    StampIDParam.Value = s.ID;
                    cmd.Parameters.Add(StampIDParam);

                    MySqlParameter StampDateandTimeParam = new MySqlParameter("@StampDateandTime", MySqlDbType.DateTime);
                    StampDateandTimeParam.Value = s.DateAndTime;
                    cmd.Parameters.Add(StampDateandTimeParam);

                    MySqlParameter StampRemarkParam = new MySqlParameter("@StampRemark", MySqlDbType.VarChar);
                    StampRemarkParam.Value = s.Remark;
                    cmd.Parameters.Add(StampRemarkParam);

                    MySqlParameter StampWorkcodeParam = new MySqlParameter("@StampWorkcode", MySqlDbType.Int32);
                    StampWorkcodeParam.Value = s.Workcode;
                    cmd.Parameters.Add(StampWorkcodeParam);

                    MySqlParameter IsIgnoredParam = new MySqlParameter("@IsIgnored", MySqlDbType.Int16);
                    IsIgnoredParam.Value = Convert.ToInt16(s.IsIgnored);
                    cmd.Parameters.Add(IsIgnoredParam);

                    MySqlParameter UserIDParam = new MySqlParameter("@UserID", MySqlDbType.Int32);
                    UserIDParam.Value = s.UserID;
                    cmd.Parameters.Add(UserIDParam);


                    cmd.ExecuteNonQuery();
                }
                catch (Exception e)
                {
                    Console.WriteLine("Error: " + e);
                    Console.WriteLine(e.StackTrace);
                }
            }

        }
        static void InsertDaysInToDB(MySqlConnection conn, List<Day> allDays)
        {
            foreach (Day u in allDays)
            {
                try
                {
                    string sql = "Insert into days (DayDate,DayIsValide, UserID)"
                                    + " values (@DayDate, @DayIsValide, @UserID) ";
                    MySqlCommand cmd = conn.CreateCommand();
                    cmd.CommandText = sql;

                    MySqlParameter DayDateParam = new MySqlParameter("@DayDate", MySqlDbType.Date);
                    DayDateParam.Value = u.DateOfDay;
                    cmd.Parameters.Add(DayDateParam);

                    MySqlParameter DayIsValideParam = new MySqlParameter("@DayIsValide", MySqlDbType.Int16);
                    DayIsValideParam.Value = Convert.ToInt16(u.IsValid);
                    cmd.Parameters.Add(DayIsValideParam);

                    MySqlParameter UserIDParam = new MySqlParameter("@UserID", MySqlDbType.Int32);
                    UserIDParam.Value = u.UserID;
                    cmd.Parameters.Add(UserIDParam);

                    cmd.ExecuteNonQuery();
                }
                catch (Exception e)
                {
                    Console.WriteLine("Error: " + e);
                    Console.WriteLine(e.StackTrace);
                }
            }

        }

    }
    
}
