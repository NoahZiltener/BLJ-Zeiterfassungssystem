using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Data;
using FirebirdSql.Data.FirebirdClient;

namespace datatransfer
{
    class User
    {
        public int ID { get; set; }
        public string Firstname { get; set; }
        public string Lastname { get; set; }
        public string Username { get; set; }
        public bool compareUsers(User s)
        {
            bool compareBool = false;
            if (s.ID == ID)
            {
                compareBool = true;

            }
            return compareBool;
        }
    }
}
