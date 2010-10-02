// ** I18N
Calendar._DN = new Array
("Воскресенье",
 "Понедельник",
 "Вторник",
 "Среда",
 "Четверг",
 "Пятница",
 "Суббота",
 "Воскресенье");
Calendar._SDN = new Array
("Вс",
 "Пн",
 "Вт",
 "Ср",
 "Чт",
 "Пт",
 "Сб",
 "Вс");
Calendar._SDN_len = 2;

Calendar._MN = new Array
("Январь",
 "Февраль",
 "Март",
 "Апрель",
 "Май",
 "Июнь",
 "Июль",
 "Август",
 "Сентябрь",
 "Октябрь",
 "Ноябрь",
 "Декабрь");
Calendar._SMN = new Array
("Янв",
 "Фев",
 "Мар",
 "Апр",
 "Мая",
 "Июн",
 "Июл",
 "Авг",
 "Сен",
 "Окт",
 "Ноя",
 "Дек");

// tooltips
if(Calendar._TT == undefined) if(Calendar._TT == undefined) Calendar._TT = {};
Calendar._TT["TOGGLE"] = "Сменить день начала недели (ПН/ВС)";
Calendar._TT["PREV_YEAR"] = "Пред. год (удерживать для меню)";
Calendar._TT["PREV_MONTH"] = "Пред. месяц (удерживать для меню)";
Calendar._TT["GO_TODAY"] = "На сегодня";
Calendar._TT["NEXT_MONTH"] = "След. месяц (удерживать для меню)";
Calendar._TT["NEXT_YEAR"] = "След. год (удерживать для меню)";
Calendar._TT["SEL_DATE"] = "Выбрать дату";
Calendar._TT["DRAG_TO_MOVE"] = "Перетащить";
Calendar._TT["PART_TODAY"] = " (сегодня)";
Calendar._TT["MON_FIRST"] = "Показать понедельник первым";
Calendar._TT["SUN_FIRST"] = "Показать воскресенье первым";
Calendar._TT["DAY_FIRST"] = "Показать %s первым";
Calendar._TT["CLOSE"] = "Закрыть";
Calendar._TT["TODAY"] = "Сегодня";

// date formats
Calendar._TT["DEF_DATE_FORMAT"] = "%Y-%m-%d";
Calendar._TT["TT_DATE_FORMAT"] = "%a, %e %b";

Calendar._TT["WK"] = "нед";
