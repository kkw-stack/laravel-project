import { useEffect, useRef, useState } from "react";

export default function Calendar({ config, value, setValue }) {
    // Ref
    const datepickerRef = useRef(null);

    // State
    const [datepicker, setDatepicker] = useState(null);
    const now = dayjs();
    const maxDate = dayjs().add(config?.max_date || 30, 'day');
    let count = 0;

    const isSameOrBefore = (target, compare) => dayjs(target).isSame(dayjs(compare)) || dayjs(target).isBefore(dayjs(compare));
    const isSameOrAfter = (target, compare) => dayjs(target).isSame(dayjs(compare)) || dayjs(target).isAfter(dayjs(compare));
    const isSameDate = ( date ) => {
        count++;

        if( (config?.closed_weekday || []).includes(date.get('day').toString()) ){
            if( count >= ( config?.max_date || 30 ) ){
                return now;
            }
            return isSameDate( date.add(1, 'day') );
        }

        for( let closeDate of ( config?.closed_dates || [] ) ){
            if( date.format('YYYY-MM-DD') >= closeDate.start && date.format('YYYY-MM-DD') <= closeDate.end ){
                if( count >= ( config?.max_date || 30 ) ){
                    return now;
                }
                return isSameDate( date.add(1, 'day') );
            }
        }

        return date;
    };

    useEffect(() => {
        if( !value ){
            datepicker?.clear();
        }
    }, [value]);

    useEffect(() => {
        datepicker?.update({
            onSelect: ({ date }) => {
                setValue(date ? dayjs(date).format("YYYY-MM-DD") : "");
            }
        });
    }, [setValue]);

    useEffect(() => {
        let selectDate = now.add(1, 'day');

        if( datepicker ){
            selectDate = isSameDate( selectDate );
            datepicker.setViewDate( selectDate );
        }
    }, [ datepicker ]);

    useEffect(() => {

        setDatepicker(
            new AirDatepicker(datepickerRef.current, {
                classes: "jt-datepicker",
                inline: true,
                locale: ( document.documentElement.lang === 'en' ) ? JT.globals.datepicker.locale.en : JT.globals.datepicker.locale.ko,
                toggleSelected: false,
                navTitles: {
                    days: '<span class="jt-typo--09">yyyy. MM</span>',
                    months: '<span class="jt-typo--09">yyyy</span>',
                    years: '<span class="jt-typo--09">yyyy1 ~ yyyy2</span>',
                },
                prevHtml: '<div class="air-datepicker-nav--inner"><i class="jt-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 34"><path d="M21.21,23.3l-6.3-6.38,6.29-6.21a1,1,0,0,0-1.4-1.42l-7,6.91a1,1,0,0,0-.3.71,1,1,0,0,0,.29.7l7,7.09a1,1,0,0,0,1.42-1.4Z"/></svg></i></div>',
                nextHtml: '<div class="air-datepicker-nav--inner"><i class="jt-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 34"><path d="M14.21,24.7l7-7.09a1,1,0,0,0,.29-.7,1,1,0,0,0-.3-.71l-7-6.91a1,1,0,1,0-1.4,1.42l6.29,6.21-6.3,6.38a1,1,0,1,0,1.42,1.4Z"/></svg></i></div>',
                onRenderCell: ({ date, cellType, datepicker }) => {
                    const current = dayjs(date);

                    // 예약 가능 기간
                    if (isSameOrBefore(current, now) || current.isAfter(maxDate)) {
                        datepicker.disableDate(date);
                    }

                    // 정기 휴관일
                    if ((config?.closed_weekday || []).includes(current.day().toString())) {
                        datepicker.disableDate(date);
                    }

                    // 별도 휴관일
                    (config?.closed_dates || []).map((item) => {
                        if (isSameOrAfter(current, item.start) && isSameOrBefore(current, item.end)) {
                            datepicker.disableDate(date);
                        }
                    });

                    return {
                        html: `<div class="air-datepicker-cell-inner"><span class="jt-typo--15">${
                            cellType === "day"
                                ? dayjs(date).date()
                                : cellType === "month"
                                ? dayjs(date).month() + 1
                                : dayjs(date).year()
                        }</span></div>`,
                    };
                },
                onSelect: ({ date }) => {
                    setValue(date ? dayjs(date).format("YYYY-MM-DD") : "");
                },
            })
        );
    }, []);

    return (
        <div className="jt-reservation__datepicker" ref={datepickerRef}></div>
    );
}
