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

        public bool compareStamps(Stamp s)
        {
            bool compareBool = false;
            if(s.ID == ID)
            {
                compareBool = true;
                
            }
            return compareBool;
            
        }
        public bool isStampsdifferent(Stamp s)
        {
            bool compareBool = false;
            if (s.IsIgnored != IsIgnored && s.ID == ID)
            {
                compareBool = true;

            }
            return compareBool;

        }
        public bool isStampsdouble(Stamp s)
        {
            bool compareBool = false;
            TimeSpan d = new TimeSpan();
            if(DateAndTime > s.DateAndTime)
            {
                d = DateAndTime - s.DateAndTime;
            }
            else
            {
                d = s.DateAndTime - DateAndTime;
            }
            if(d.TotalSeconds < 5 && s.UserID == UserID)
            {
                compareBool = true;
            }
            return compareBool;
        }
    }
}
