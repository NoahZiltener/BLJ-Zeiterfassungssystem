using MySql.Data.MySqlClient;
using System;
using System.Collections.Generic;
using System.Configuration;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace datatransfer
{
    class DBUtils
    {
        public static MySqlConnection GetDBConnection()
        {
            string host = ConfigurationManager.AppSettings.Get("host"); 
            int port = Convert.ToInt32(ConfigurationManager.AppSettings.Get("port"));
            string database = ConfigurationManager.AppSettings.Get("database");
            string username = ConfigurationManager.AppSettings.Get("username");
            string password = ConfigurationManager.AppSettings.Get("password");

            return DBMySQLUtils.GetDBConnection(host, port, database, username, password);
        }
    }
}
