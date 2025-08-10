export default function PriceItem({ name, label, price, disabled, value, increase, decrease, locale, __ }) {
    return (
        <div className="jt-reservation__price-item">
            <div className="jt-reservation__price-title">
                <b className="jt-typo--13">{label}</b>
                { (locale != 'en' && name === 'child' ) && <span className="jt-typo--17">직계가족 동반시 무료</span> }
            </div>

            <div className="jt-reservation__price-info">
                <span className="jt-typo--13">
                    {price > 0 ? __('reservation.common.price', {'PRICE': price.toLocaleString("ko-KR")}) : __('reservation.common.free')}
                </span>

                <div className="jt-reservation__price-control">
                    <button
                        type="button"
                        className="jt-reservation__price-btn jt-reservation__price-btn--decrement"
                        onClick={() => decrease()}
                        disabled={value === 0}
                    >
                        <i className="jt-icon">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 32 32"
                            >
                                <path d="M12,15h8a1,1,0,0,1,1,1h0a1,1,0,0,1-1,1H12a1,1,0,0,1-1-1h0A1,1,0,0,1,12,15Z" />
                            </svg>
                        </i>
                    </button>
                    <span className="jt-typo--13">{value}</span>
                    <button
                        type="button"
                        className="jt-reservation__price-btn jt-reservation__price-btn--increment"
                        onClick={() => increase()}
                        disabled={disabled}
                    >
                        <i className="jt-icon">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 32 32"
                            >
                                <path d="M20,15H17V12a1,1,0,0,0-2,0v3H12a1,1,0,0,0,0,2h3v3a1,1,0,0,0,2,0V17h3a1,1,0,0,0,0-2Z" />
                            </svg>
                        </i>
                    </button>
                </div>
            </div>
        </div>
    );
}
