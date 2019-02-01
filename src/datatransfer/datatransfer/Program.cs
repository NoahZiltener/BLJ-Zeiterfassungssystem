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
using System.Data.Common;

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

            cmdfd.CommandText = "select * from USERS";
            adap.Fill(dtu);
            cmdfd.CommandText = "select * from ATTENDANT order by \"WHEN\" asc";
            adap.Fill(dtt);

            List<User> allusers = new List<User>();
            List<Stamp> allstamps = new List<Stamp>();
            List<Day> allDays = new List<Day>();
            List<User> allusersfromedb = new List<User>();
            List<Stamp> allstampsfromdb = new List<Stamp>();
            List<Day> allDaysfromdb = new List<Day>();

            CreateUser(dtu, allusers);
            CreateStamp(dtt, allstamps);
            CreateDay(allstamps, allDays);

            foreach (Day d in allDays)
            {
                d.IsValid = d.IsValidDay();
                if (d.IsValid == true)
                {
                    d.TimeOfDay = d.GetTimeOfDay();
                    d.worktime = d.GetWorkTime();
                    d.lunchtime = d.Getlunchtime();
                    d.overtime = d.GetOverTime();
                }
            }

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
            getuserfromDB(conn, allusersfromedb);
            getStampsfromDB(conn, allstampsfromdb);
            getDaysfromDB(conn, allDaysfromdb);

            InsertUsersInToDB(conn, allusers, allusersfromedb);
            InsertStampsInToDB(conn, allstamps, allstampsfromdb);
            InsertDaysInToDB(conn, allDays, allDaysfromdb);
            Console.WriteLine("Transfer successful!");
            Console.Beep();

            ////Ausgabe der Daten
            ////foreach (User u in allusers)
            ////{
            ////    Console.WriteLine("User ID: " + u.ID);
            ////    Console.WriteLine("User Vorname: " + u.Firstname);
            ////    Console.WriteLine("User Nachname: " + u.Lastname);
            ////    Console.WriteLine("User Username: " + u.Username + "\n");
            ////}
            ////foreach (Stamp t in allstamps)
            ////{
            ////    Console.WriteLine("Zeit ID: " + t.ID);
            ////    Console.WriteLine("User ID: " + t.UserID);
            ////    Console.WriteLine("DateAndTime: " + t.DateAndTime);
            ////    Console.WriteLine("Workcode: " + t.Workcode);
            ////    Console.WriteLine("Remark: " + t.Remark);
            ////    Console.WriteLine("IsIgnored: " + t.IsIgnored + "\n");
            ////}
            //List<double> overtimeall = new List<double>();
            //foreach (Day d in allDays)
            //{
            //    if (d.UserID == 29)
            //    {
            //        Console.WriteLine("UserID: " + d.UserID);
            //        //Console.WriteLine("DayID: " + d.DayID);
            //        //Console.WriteLine("Zeiten: ");
            //        //foreach (Stamp stamp in d.Stamps)
            //        //{
            //        //    if (stamp.IsIgnored != true)
            //        //    {
            //        //        Console.WriteLine(stamp.DateAndTime);
            //        //    }
            //        //}
            //        //Console.WriteLine("DateOfDay: " + d.DateOfDay);
            //        Console.WriteLine("worktime: " + d.worktime);
            //        Console.WriteLine("lunchtime: " + d.lunchtime);
            //        Console.WriteLine("overtime: " + d.overtime);
            //        overtimeall.Add(d.overtime);
            //        Console.WriteLine("TimeOfDay: " + d.TimeOfDay + "\n");
            //        //Console.WriteLine("IsValid: " + d.IsValid + "\n");
            //    }
            //}
            //double ovot = 0;
            //foreach (double ov in overtimeall)
            //{
            //    ovot = ov + ovot;
            //}
            //Console.WriteLine(ovot);
            //foreach (User u in allusersfromedb)
            //{
            //    Console.WriteLine("UserID: " + u.ID);
            //    Console.WriteLine("Firstname: " + u.Firstname);
            //    Console.WriteLine("Lastname: " + u.Lastname);
            //    Console.WriteLine("Username: " + u.Username + "\n");
            //}
            //foreach (Stamp t in allstampsfromdb)
            //{
            //    Console.WriteLine("Zeit ID: " + t.ID);
            //    Console.WriteLine("User ID: " + t.UserID);
            //    Console.WriteLine("DateAndTime: " + t.DateAndTime);
            //    Console.WriteLine("Workcode: " + t.Workcode);
            //    Console.WriteLine("Remark: " + t.Remark);
            //    Console.WriteLine("IsIgnored: " + t.IsIgnored + "\n");
            //}
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
            Console.WriteLine("User Createt!");
        }
        static void CreateStamp(DataTable dt, List<Stamp> stamps)
        {
            foreach (DataRow row in dt.Rows)
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
                else if (row["updatechangewhen"] != DBNull.Value)
                {
                    s.UpdateDate = Convert.ToDateTime(row["updatechangewhen"]);
                    s.UpdateUserID = Convert.ToInt32(row["UPDATEUSERID"]);
                }

            }
            Console.WriteLine("Stamps Created!");
        }
        static void CreateDay(List<Stamp> stamps, List<Day> days)
        {
            int ID = 0;
            foreach (Stamp stamp in stamps)
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
                d.DayID = ID;
                ID++;
            }
            Console.WriteLine("Days Created!");
        }
        static void InsertUsersInToDB(MySqlConnection conn, List<User> allusers, List<User> allusersfromdb)
        {
            List<User> usernotindb = new List<User>();
            List<int> allUserids = new List<int>();
            List<int> allusersfromdbids = new List<int>();
            foreach (User u in allusers)
            {
                allUserids.Add(u.ID);
            }
            foreach (User u in allusersfromdb)
            {
                allusersfromdbids.Add(u.ID);
            }
            foreach (int i in allusersfromdbids)
            {
                if (allUserids.Contains(i))
                {
                    allUserids.Remove(i);
                }
            }
            foreach (int id in allUserids)
            {
                User user = allusers.Find(
                delegate (User u)
                {
                    return u.ID == id;
                }
                );
                usernotindb.Add(user);
            }
            foreach (User u in usernotindb)
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
            Console.WriteLine("Insert Users completed!");
        }
        static void InsertStampsInToDB(MySqlConnection conn, List<Stamp> allstamps, List<Stamp> allstampsfromdb)
        {
            List<Stamp> Stampnotindb = new List<Stamp>();
            List<int> allStampids = new List<int>();
            List<int> allStampsfromdbids = new List<int>();
            foreach (Stamp s in allstamps)
            {
                allStampids.Add(s.ID);
            }
            foreach (Stamp s in allstampsfromdb)
            {
                allStampsfromdbids.Add(s.ID);
            }
            foreach (int i in allStampsfromdbids)
            {
                if (allStampids.Contains(i))
                {
                    allStampids.Remove(i);
                }
            }
            foreach (int id in allStampids)
            {
                Stamp stamp = allstamps.Find(
                delegate (Stamp s)
                {
                    return s.ID == id;
                }
                );
                Stampnotindb.Add(stamp);
            }
            foreach (Stamp s in Stampnotindb)
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
            Console.WriteLine("Insert Stamps completet!");
        }
        static void InsertDaysInToDB(MySqlConnection conn, List<Day> allDays, List<Day> allDaysfromdb)
        {
            List<Day> Daynotindb = new List<Day>();
            List<int> allDaydayID = new List<int>();
            List<int> allDayfromdbdayID = new List<int>();
            foreach (Day d in allDays)
            {
                allDaydayID.Add(d.DayID);
            }
            foreach (Day d in allDaysfromdb)
            {
                allDayfromdbdayID.Add(d.DayID);
            }
            foreach (int i in allDayfromdbdayID)
            {
                if (allDaydayID.Contains(i))
                {
                    allDaydayID.Remove(i);
                }
            }
            foreach (int id in allDaydayID)
            {
                Day Day = allDays.Find(            
                delegate (Day d)
                {
                    return d.DayID == id;
                }
                );
                Daynotindb.Add(Day);
            }
            foreach (Day u in Daynotindb)
            {
                try
                {
                    string sql = "Insert into days (DayID, DayDate,DayIsValide, UserID, overtime, TimeOfDay, worktime, lunchtime)"
                                    + " values (@DayID, @DayDate, @DayIsValide, @UserID, @overtime, @TimeOfDay, @worktime, @lunchtime) ";
                    MySqlCommand cmd = conn.CreateCommand();
                    cmd.CommandText = sql;

                    MySqlParameter DayIDParam = new MySqlParameter("@DayID", MySqlDbType.Int32);
                    DayIDParam.Value = u.DayID;
                    cmd.Parameters.Add(DayIDParam);

                    MySqlParameter DayDateParam = new MySqlParameter("@DayDate", MySqlDbType.Date);
                    DayDateParam.Value = u.DateOfDay;
                    cmd.Parameters.Add(DayDateParam);

                    MySqlParameter DayIsValideParam = new MySqlParameter("@DayIsValide", MySqlDbType.Int16);
                    DayIsValideParam.Value = Convert.ToInt16(u.IsValid);
                    cmd.Parameters.Add(DayIsValideParam);

                    MySqlParameter UserIDParam = new MySqlParameter("@UserID", MySqlDbType.Int32);
                    UserIDParam.Value = u.UserID;
                    cmd.Parameters.Add(UserIDParam);

                    MySqlParameter overtimeParam = new MySqlParameter("@overtime", MySqlDbType.Double);
                    overtimeParam.Value = Convert.ToDouble(u.overtime);
                    cmd.Parameters.Add(overtimeParam);

                    MySqlParameter TimeOfDayParam = new MySqlParameter("@TimeOfDay", MySqlDbType.Double);
                    TimeOfDayParam.Value = u.TimeOfDay;
                    cmd.Parameters.Add(TimeOfDayParam);

                    MySqlParameter worktimeParam = new MySqlParameter("@worktime", MySqlDbType.Double);
                    worktimeParam.Value = u.worktime;
                    cmd.Parameters.Add(worktimeParam);

                    MySqlParameter lunchtimeParam = new MySqlParameter("@lunchtime", MySqlDbType.Double);
                    lunchtimeParam.Value = u.lunchtime;
                    cmd.Parameters.Add(lunchtimeParam);

                    cmd.ExecuteNonQuery();
                }
                catch (Exception e)
                {
                    Console.WriteLine("Error: " + e);
                    Console.WriteLine(e.StackTrace);
                }
            }
            Console.WriteLine("Insert Days completet!");
        }
        static void getuserfromDB(MySqlConnection conn, List<User> allusersfromDB)
        {
            string sql = "Select * from users";
            MySqlCommand cmd = new MySqlCommand();

            cmd.Connection = conn;
            cmd.CommandText = sql;

            using (DbDataReader reader = cmd.ExecuteReader())
            {
                if (reader.HasRows)
                {
                    while (reader.Read())
                    {
                        int UserIDIndex = reader.GetOrdinal("UserID");
                        int UserID = Convert.ToInt32(reader.GetValue(UserIDIndex));
                        int UserFirstNameIndex = reader.GetOrdinal("UserFirstName");
                        string UserFirstName = reader.GetString(UserFirstNameIndex);
                        int UserLastNameIndex = reader.GetOrdinal("UserLastName");
                        string UserLastName = reader.GetString(UserLastNameIndex);
                        int UserNameIndex = reader.GetOrdinal("UserName");
                        string UserName = reader.GetString(UserNameIndex);

                        User u = new User();
                        u.ID = UserID;
                        u.Firstname = UserFirstName;
                        u.Lastname = UserLastName;
                        u.Username = UserName;
                        allusersfromDB.Add(u);
                    }
                }
            }
        }
        static void getStampsfromDB(MySqlConnection conn, List<Stamp> allStampsfromDB)
        {
            string sql = "Select * from stamps";
            MySqlCommand cmd = new MySqlCommand();

            cmd.Connection = conn;
            cmd.CommandText = sql;

            using (DbDataReader reader = cmd.ExecuteReader())
            {
                if (reader.HasRows)
                {
                    while (reader.Read())
                    {
                        int StampIDIndex = reader.GetOrdinal("StampID");
                        int StampID = Convert.ToInt32(reader.GetValue(StampIDIndex));

                        int StampDateandTimeIndex = reader.GetOrdinal("StampDateandTime");
                        DateTime StampDateandTime = Convert.ToDateTime(reader.GetValue(StampDateandTimeIndex));

                        int StampRemarkIndex = reader.GetOrdinal("StampRemark");
                        string StampRemark = reader.GetString(StampRemarkIndex);

                        int StampWorkcodeIndex = reader.GetOrdinal("StampWorkcode");
                        int StampWorkcode = Convert.ToInt32(reader.GetValue(StampWorkcodeIndex));

                        int IsIgnoredIndex = reader.GetOrdinal("IsIgnored");
                        bool IsIgnored = Convert.ToBoolean(reader.GetValue(IsIgnoredIndex));

                        int UserIDIndex = reader.GetOrdinal("UserID");
                        int UserID = Convert.ToInt32(reader.GetValue(UserIDIndex));

                        Stamp s = new Stamp();
                        s.ID = StampID;
                        s.DateAndTime = StampDateandTime;
                        s.Remark = StampRemark;
                        s.Workcode = StampWorkcode;
                        s.IsIgnored = IsIgnored;
                        s.UserID = UserID;
                        allStampsfromDB.Add(s);
                    }
                }
            }
        }
        static void getDaysfromDB(MySqlConnection conn, List<Day> allDaysfromDB)
        {
            string sql = "Select * from Days";
            MySqlCommand cmd = new MySqlCommand();

            cmd.Connection = conn;
            cmd.CommandText = sql;

            using (DbDataReader reader = cmd.ExecuteReader())
            {
                if (reader.HasRows)
                {
                    while (reader.Read())
                    {
                        int DayIDIndex = reader.GetOrdinal("DayID");
                        int DayID = Convert.ToInt32(reader.GetValue(DayIDIndex));

                        int UserIDIndex = reader.GetOrdinal("UserID");
                        int UserID = Convert.ToInt32(reader.GetValue(UserIDIndex));

                        int StampDateandTimeIndex = reader.GetOrdinal("DayDate");
                        DateTime StampDateandTime = Convert.ToDateTime(reader.GetValue(StampDateandTimeIndex));

                        int DayIsValideIndex = reader.GetOrdinal("DayIsValide");
                        bool DayIsValide = Convert.ToBoolean(reader.GetValue(DayIsValideIndex));

                        int overtimeIndex = reader.GetOrdinal("overtime");
                        double overtime = Convert.ToDouble(reader.GetValue(overtimeIndex));

                        int TimeOfDayIndex = reader.GetOrdinal("TimeOfDay");
                        double TimeOfDay = Convert.ToDouble(reader.GetValue(TimeOfDayIndex));

                        int worktimeIndex = reader.GetOrdinal("worktime");
                        double worktime = Convert.ToDouble(reader.GetValue(worktimeIndex));

                        int lunchtimeIndex = reader.GetOrdinal("lunchtime");
                        double lunchtime = Convert.ToDouble(reader.GetValue(lunchtimeIndex));

                        Day s = new Day(StampDateandTime, UserID);
                        s.DayID = DayID;
                        s.IsValid = DayIsValide;
                        s.overtime = overtime;
                        s.TimeOfDay = TimeOfDay;
                        s.worktime = worktime;
                        s.lunchtime = lunchtime;
                        allDaysfromDB.Add(s);
                    }
                }
            }
        }

    }
    
}
