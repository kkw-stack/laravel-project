import { useForm } from "@inertiajs/react";
import React, { useEffect, useState, useMemo } from "react";
import Calendar from "../components/Calendar";
import PriceItem from "../components/PriceItem";
import TimeItem from "../components/TimeItem";

export default function ({ config, tickets, off_message, locale, language }) {

    const defaultData = {
        ticket: "",
        select_date: "",
        select_time: "",
        use_docent: false,
        visitors: {},
    };

    const { data, setData } = useForm(defaultData);

    const [showTooltip, setShowToolip] = useState(true);
    const [ticket, setTicket] = useState(null);
    const [timeTable, setTimeTable] = useState([]);
    const [priceTable, setPriceTable] = useState([]);
    const [allowDocent, setAllowDocent] = useState(false);
    const [canUseDocent, setCanUseDocent] = useState(null);
    const [isRun, setIsRun] = useState(false);
    const [maxCount, setMaxCount] = useState(0);

    /**
     * 다국어 처리용 함수
     *
     * @link https://medium.com/@ayatir04/laravel-inertia-js-localization-without-packages-6e7f49fb07c
     */
    const __ = (key, replace = {}) => {
        try {
            let keys = key.split('.');
            let translation = language[keys[0]] || key;

            keys?.reduce((_, cur) => translation = translation[cur]);

            if( typeof translation === 'string' ){
                Object.keys(replace).map((key) => {
                    translation = translation.replace(':' + key, replace[key]);
                });
            } else {
                translation.map(( trans, idx ) => {
                    Object.keys(replace).map((key) => {
                        translation[idx] = trans.replace(':' + key, replace[key]);
                    });
                })
            }

            return translation;
        } catch (e) {
            return key;
        }
    }

    const totalVisitors = useMemo(() => {
        return Object.values(data.visitors).reduce(
            (accumulator, currentValue) => accumulator + currentValue,
            0
        );
    }, [data.visitors]);

    const totalPrice = useMemo(() => {
        let result = 0;

        for (let key in data.visitors) {
            if (data.visitors.hasOwnProperty(key)) {
                let price = priceTable.find(
                    (item) => item.name === key
                );
                let value = data.visitors[key];

                result += value * parseInt(price?.price || 0);
            }
        }

        return result;
    }, [data.visitors, priceTable]);

    const visitorLabel = useMemo(() => {
        let labels = [];

        for (let key in data.visitors) {
            const count = parseInt(data.visitors[key]);

            if (count > 0) {
                const label = priceTable.find(item => item.name === key)?.label || ''

                labels.push(__('reservation.common.visitor', {'LABEL': label, 'COUNT': count}));
            }
        }

        return labels;
    }, [data.visitors, priceTable]);

    const formSubmit = ( e ) => {
        e.preventDefault();
        e.stopPropagation();

        if( isRun ) return;
        setIsRun(true);

        e.target.submit();
    }

    useEffect(() => {
        if (data.ticket) {
            fetch(route(`${locale}.api.ticket.detail`, data.ticket)).then(res => {
                if (res.ok && res.status === 200) {
                    res.json().then(data => setTicket(data));
                }
            });
        } else {
            setTicket(null);
        }
    }, [data.ticket]);

    useEffect(() => {
        if (data.ticket && data.select_date) {
            fetch(route(`${locale}.api.ticket.time`, {
                ticket: data.ticket,
                date: data.select_date,
            })).then(res => {
                if (res.ok && res.status === 200) {
                    res.json().then(data => setTimeTable(data));
                }
            });
        } else {
            setTimeTable([]);
        }
    }, [data.select_date]);

    useEffect(() => {
        if (data.ticket && data.select_date && data.select_time) {
            fetch(route(`${locale}.api.ticket.price`, {
                ticket: data.ticket,
                date: data.select_date,
                time: data.select_time,
            })).then(res => {
                if (res.ok && res.status === 200) {
                    res.json().then(data => {
                        setAllowDocent(data?.use_docent || false);
                        setCanUseDocent(data?.can_use_docent || false);
                        setPriceTable(data?.time_table || []);
                        setMaxCount(data?.available_count || 0);
                    });
                }
            });
        } else {
            setAllowDocent(false);
            setCanUseDocent(null);
            setPriceTable([]);
        }
    }, [data.select_date, data.select_time]);

    useEffect(() => {
        for (let key in data.visitors) {
            const count = parseInt(data.visitors[key]);

            if (count === 0) {
                delete data.visitors[key];
            }
        }
    }, [data.visitors]);

    useEffect(() => {
        // JT init
        JT.ui.call("select_init");
        JT.ui.call("reservation_result_scroll");

        const handleUnload = () => {
            setIsRun(false);
        };

        window.addEventListener('pagehide', handleUnload);

        return () => {
            window.removeEventListener('pagehide', handleUnload);
        };
    }, []);

    return (
        <div className="jt-reservation">
            <div className="jt-reservation__inner">
                <div className="jt-reservation__form">
                    <fieldset className="jt-form__fieldset">
                        <div className="jt-form__entry jt-reservation__step--01">
                            <label className="jt-form__label" htmlFor="ticket">
                                <span className="jt-typo--08">{ __('reservation.form.ticket.label') }</span>
                            </label>
                            <div className="jt-form__data">
                                <div className="jt-choices__wrap">
                                    <select
                                        className="jt-choices jt-form__field--valid"
                                        id="ticket"
                                        required
                                        onChange={(e) => setData({
                                            ...defaultData,
                                            ticket: e.target.value,
                                        })}
                                    >
                                        <option value="">{ __('reservation.form.ticket.placeholder') }</option>
                                        {tickets.map((item) => (
                                            <option key={item.id} value={item.id}>{'en' === locale ? item.title.en : item.title.ko}</option>
                                        ))}
                                    </select>
                                </div>
                            </div>
                        </div>

                        {data.ticket && (
                            <div className="jt-form__entry jt-reservation__step--02">
                                <b className="jt-form__label">
                                    <span className="jt-typo--08">{ __('reservation.form.date.label') }</span>
                                </b>

                                <div className="jt-form__data">
                                    {off_message && (
                                        <ul className="jt-form__explain">
                                            <li className="jt-typo--15">{ __('reservation.form.date.off.label') } : {off_message}</li>
                                        </ul>
                                    )}

                                    <Calendar
                                        config={config}
                                        value={data.select_date}
                                        setValue={(value) => setData({
                                            ...defaultData,
                                            ticket: data.ticket,
                                            select_date: value,
                                        })}
                                    />
                                </div>
                            </div>
                        )}

                        {(data.select_date && !!timeTable.length) && (
                            <div className="jt-form__entry jt-reservation__step--03">
                                { timeTable.filter(({ time }) => { return dayjs(time, 'hh:mm').hour() < 12 }).length > 0 && (
                                    <div className="jt-form__data">
                                        <b className="jt-timepicker__label"><span className="jt-typo--15">{ __('reservation.form.time.am') }</span></b>
                                        <div className="jt-timepicker jt-radiobox--required">
                                            <div className="jt-timepicker__inner">
                                                {timeTable.map(({time, available}) => {
                                                    if( dayjs(time, 'hh:mm').hour() < 12 ){
                                                    return <TimeItem
                                                        key={time}
                                                        time={time}
                                                        disabled={available === 0}
                                                        available={available}
                                                        value={data.select_time}
                                                        setValue={(value) => setData({
                                                            ...defaultData,
                                                            ticket: data.ticket,
                                                            select_date: data.select_date,
                                                            select_time: value,
                                                        })}
                                                        __={__}
                                                    /> 
                                                    }
                                                })}
                                            </div>
                                        </div>
                                    </div>
                                )}

                                { timeTable.filter(({ time }) => { return dayjs(time, 'hh:mm').hour() >= 12 }).length > 0 && (
                                    <div className="jt-form__data">
                                        <b className="jt-timepicker__label"><span className="jt-typo--15">{ __('reservation.form.time.pm') }</span></b>
                                        <div className="jt-timepicker jt-radiobox--required">
                                            <div className="jt-timepicker__inner">
                                                {timeTable.map(({time, available}) => {
                                                    if( dayjs(time, 'hh:mm').hour() >= 12 ){
                                                    return <TimeItem
                                                        key={time}
                                                        time={time}
                                                        disabled={available === 0}
                                                        available={available}
                                                        value={data.select_time}
                                                        setValue={(value) => setData({
                                                            ...defaultData,
                                                            ticket: data.ticket,
                                                            select_date: data.select_date,
                                                            select_time: value,
                                                        })}
                                                        __={__}
                                                    /> 
                                                    }
                                                })}
                                            </div>
                                        </div>
                                    </div>
                                )}

                                {(data.select_time && (canUseDocent !== null) && allowDocent) && (
                                    <div className="jt-form__data">
                                        <div className="jt-checkbox">
                                            <label>
                                                <input
                                                    type="checkbox"
                                                    onChange={(e) => setData({
                                                        ...data,
                                                        use_docent: e.target.checked,
                                                    })}
                                                    checked={data.use_docent && allowDocent && canUseDocent}
                                                    disabled={!allowDocent || !canUseDocent}
                                                />
                                                <span>{ __('reservation.form.docent.text') }</span>
                                            </label>

                                            {showTooltip && (
                                                <div className="jt-reservation__tooltip">
                                                    <i className="jt-reservation__tooltip-chervon"></i>
                                                    <div className="jt-reservation__tooltip-content">
                                                        <p className="jt-typo--17" dangerouslySetInnerHTML={{
                                                            __html: !canUseDocent
                                                            ? __('reservation.form.docent.tooltip.close')
                                                            : !allowDocent
                                                            ? __('reservation.form.docent.tooltip.disallow')
                                                            : __('reservation.form.docent.tooltip.allow')
                                                        }}></p>
                                                        <button type="button" className="jt-reservation__tooltip-close" onClick={() => setShowToolip(false)}>
                                                            <i className="jt-icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                                                                    <path d="M9.4,8.07,12.71,4.7a1,1,0,0,0-1.42-1.4L8,6.64,4.71,3.3A1,1,0,0,0,3.29,4.7L6.6,8.07,3.42,11.3a1,1,0,1,0,1.42,1.4L8,9.49l3.16,3.21a1,1,0,1,0,1.42-1.4Z" />
                                                                </svg>
                                                            </i>
                                                            <span className="sr-only">{ __('ui.close') }</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            )}
                                        </div>
                                    </div>
                                )}
                            </div>
                        )}

                        {(data.select_time && !!priceTable.length) && (
                            <div className="jt-form__entry jt-reservation__step--04">
                                <b className="jt-form__label">
                                    <span className="jt-typo--08">{ __('reservation.form.price.label') }</span>
                                </b>
                                <p className="jt-form__explain jt-typo--15">{ __('reservation.form.price.explain', {'MAX': config.max_count, 'CURRENT': maxCount - totalVisitors}) }</p>
                                <div className="jt-form__data">
                                    <div className="jt-reservation__price">
                                        {priceTable.map(({ name, label, price }) => (
                                            <PriceItem
                                                key={name}
                                                name={name}
                                                label={label}
                                                price={price}
                                                disabled={maxCount <= totalVisitors}
                                                value={data.visitors[name] ?? 0}
                                                increase={() => setData({
                                                    ...data,
                                                    visitors: {
                                                        ...data.visitors,
                                                        [name]: Math.max(0, (data.visitors[name] || 0) + 1),
                                                    },
                                                })}
                                                decrease={() => setData({
                                                    ...data,
                                                    visitors: {
                                                        ...data.visitors,
                                                        [name]: Math.max(0, (data.visitors[name] || 0) - 1),
                                                    },
                                                })}
                                                locale={locale}
                                                __={__}
                                            />
                                        ))}
                                    </div>
                                </div>

                                <div className="jt-form__warning">
                                    <ul className="jt-form__warning-list">
                                        { __('reservation.form.warning', {'MAX': config.max_count}).map((desc, idx) => <li className="jt-typo--15" key={idx} dangerouslySetInnerHTML={{ __html: desc }}></li>) }
                                    </ul>
                                </div>
                            </div>
                        )}
                    </fieldset>
                </div>

                <div className="jt-reservation__result">
                    <div className="jt-reservation__result-sticky">
                        <div className="jt-reservation__result-content">
                            <div className="jt-reservation__result-content-inner">
                                {ticket && (
                                    <div className="jt-reservation__result-data">
                                        <b className="jt-reservation__result-title jt-typo--05">{ticket.title}</b>
                                        <ul className="jt-reservation__result-list">
                                            <li>
                                                <b className="jt-typo--15">{ __('reservation.result.sector') }</b>
                                                <span className="jt-typo--15">{ticket.sector}</span>
                                            </li>
                                            <li>
                                                <b className="jt-typo--15">{ __('reservation.result.date') }</b>
                                                <span className="jt-typo--15">{data.select_date ? (locale === 'en' ? dayjs(data.select_date).format('dddd, MMMM DD, YYYY') : dayjs(data.select_date).format('YYYY년 MM월 D일(ddd)')) : ''}</span>
                                            </li>
                                            <li>
                                                <b className="jt-typo--15">{ __('reservation.result.time') }</b>
                                                <span className="jt-typo--15">
                                                    {data.select_time ? `${dayjs(data.select_time, "hh:mm").format("A hh:mm")}${data.use_docent ? `(${ __('reservation.result.docent') })` : ""}` : ""}
                                                </span>
                                            </li>
                                            <li>
                                                <b className="jt-typo--15">{ __('reservation.result.visitor') }</b>
                                                <p className="jt-typo--15">
                                                    {visitorLabel.map((item, idx) => (
                                                        <React.Fragment key={idx}>
                                                            {idx > 0 && ', '}
                                                            <span>{item}</span>
                                                        </React.Fragment>
                                                    ))}
                                                </p>
                                            </li>
                                        </ul>

                                        <div className="jt-reservation__result-last">
                                            <div className="jt-reservation__result-price">
                                                <b className="jt-typo--12">{ __('reservation.result.total') }</b>
                                                <span className="jt-typo--08">{ __('reservation.common.price', {'PRICE':totalPrice.toLocaleString("ko-KR")}) }</span>
                                            </div>
                                        </div>
                                    </div>
                                )}

                                {ticket === null && (
                                    <>
                                        <div className="jt-reservation__result-empty">
                                            <p className="jt-type--13">{ __('reservation.result.empty') }</p>
                                        </div>
                                        <div className="jt-reservation__result-last">
                                            <div className="jt-reservation__result-price">
                                                <b className="jt-typo--12">{ __('reservation.result.total') }</b>
                                                <span className="jt-typo--08">{ __('reservation.common.price', {'PRICE':totalPrice.toLocaleString("ko-KR")}) }</span>
                                            </div>
                                        </div>
                                    </>
                                )}

                                <div className="jt-form__warning">
                                    <ul className="jt-form__warning-list">
                                        { __('reservation.result.warning').map((desc, idx) => <li className="jt-typo--16" key={idx} dangerouslySetInnerHTML={{ __html: desc }}></li>) }
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {totalVisitors > 0 && (
                            <div className="jt-reservation__result-payment">
                                <form method="post" onSubmit={formSubmit}>
                                    <input type="hidden" name="ticket" value={data.ticket} />
                                    <input type="hidden" name="select_date" value={data.select_date} />
                                    <input type="hidden" name="select_time" value={data.select_time} />
                                    <input type="hidden" name="use_docent" value={data.use_docent ? '1' : '0'} />

                                    {Object.keys(data.visitors).map(key => (
                                        <input key={key} type="hidden" name={`visitors[${key}]`} value={data.visitors[key]} />
                                    ))}

                                    <button type="submit" className="jt-form__action">
                                        <span className="jt-typo--12">{ __('reservation.result.submit.save') }</span>
                                    </button>
                                </form>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </div>
    );
}
