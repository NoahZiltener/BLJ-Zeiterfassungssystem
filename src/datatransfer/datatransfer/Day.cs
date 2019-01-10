using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace datatransfer
{
    class Day
    {
        public int DayID { get; set; }
        public List<Stamp> Stamps { get; private set; }
        public DateTime DateOfDay { get; set; }
        public bool IsValid {get; set; }
        public int UserID { get; set; }
        public double overtime { get; set; }
        public double TimeOfDay { get; set; }
        public double worktime { get; set; }
        public double lunchtime { get; set; } 

        public Day(DateTime dateOfDay, int userid)
        {
            DateOfDay = dateOfDay.Date;
            UserID = userid;
            Stamps = new List<Stamp>();
        }

        /// <summary>
        /// Für einen Tag muss zwingend eine gerade Anzahl Stamps vorhanden sein.
        /// </summary>
        /// <returns>True, if it's a valid day.</returns>
        public bool IsValidDay()
        {
            DateTime dt = new DateTime();

            if (Stamps.Count > 0)
            {
                dt = Stamps[0].DateAndTime.Date;

                foreach (Stamp s in Stamps)
                {
                    if (s.DateAndTime.Date != dt )
                        throw new Exception("Invalid Day object: stamps of different dates found!");
                    else if (s.DateAndTime.Date != DateOfDay)
                        throw new Exception("Invalid Day object: stamps with date different to DateOfDay found!");

                }
            }

            int count = 0;
            foreach (Stamp s in Stamps)
            {
                if (!s.IsIgnored)
                    count++;
            }

            if (count % 2 != 0)
                return false;

            return true;
        }
        public double GetWorkTime()
        {
            DateTime StampIn = new DateTime();
            DateTime StampOut = new DateTime();
            TimeSpan Timeperiod = new TimeSpan();
            TimeSpan WorkTime = new TimeSpan();
            if (Stamps.Count() > 2)
            { 
                int i = 0;
                int i2 = 1;
                while ( i2 < Stamps.Count())
                {
                    StampIn = Stamps[i].DateAndTime;
                    StampOut = Stamps[i2].DateAndTime;
                    Timeperiod = StampOut - StampIn;
                    WorkTime = WorkTime + Timeperiod;
                    i = i + 2;
                    i2 = i2 + 2;
                }
                return WorkTime.TotalHours;
            }
            else
            {
                return TimeOfDay;
            }
        }
        public double Getlunchtime()
        {
            double lunchtime;
            lunchtime = TimeOfDay - worktime;
            return lunchtime;
        }
        public double GetTimeOfDay()
        {
            DateTime StampCome = new DateTime();
            DateTime StampGo = new DateTime();
            TimeSpan TimeOfDay = new TimeSpan();

            StampCome = Stamps[0].DateAndTime;
            StampGo = Stamps[Stamps.Count() - 1].DateAndTime;
            TimeOfDay = StampGo - StampCome;

            return TimeOfDay.TotalHours;
        }
        public double GetOverTime()
        {
            double OverTime = 0; 
           
            
            OverTime = worktime - 8;
            return OverTime;
        }


    }
}
