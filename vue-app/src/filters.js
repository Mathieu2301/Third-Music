import * as moment from 'moment';
import defineFR from './moment-fr';

defineFR(moment);

export default {
  date_format: (date) => moment(date).fromNow(),
  stat_format: (stat) => {
    if (stat > 1000000) return `${Math.round(stat / 100000) / 10}M`;
    if (stat > 1000) return `${Math.round(stat / 100) / 10}K`;
    return Math.round(stat);
  },
};
