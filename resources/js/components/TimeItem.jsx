export default function TimeItem({ time, disabled, value, setValue, available, __ }) {
    return (
        <div className="jt-timepicker__item">
            <label>
                <input
                    type="radio"
                    name="time"
                    value={time}
                    checked={time === value}
                    onChange={(e) => setValue(e.target.value)}
                    disabled={disabled}
                />
                <span className="jt-typo--15">
                    {dayjs(time, "hh:mm").format("hh:mm")} 
                </span>
                <em className="jt-typo--17">{disabled ? __('reservation.form.time.close') : available}</em>
            </label>
        </div>
    );
}
