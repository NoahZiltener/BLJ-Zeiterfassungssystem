using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace datatransfer
{
    class Stamp
    {
        public int ID { get; set; }
        public DateTime DateAndTime { get; set; }
        public string Remark { get; set; }
        public int Workcode { get; set; }
        public int UserID { get; set; }
        /// <summary>
        /// UPDATEINOUT = 4 -> Ignoriert
        /// </summary>
        public bool IsIgnored { get; set; }
        public int UpdateUserID { get; set; }
        public DateTime UpdateDate { get; set; }
    }
}
