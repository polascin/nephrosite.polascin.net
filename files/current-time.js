(() => {
  const dayMs = 86400000;
  const hourMs = 3600000;
  const dateTimeFormat = new Intl.DateTimeFormat('sk-SK', {
    dateStyle: 'full',
    timeStyle: 'long'
  });
  const timeZoneFormat = new Intl.DateTimeFormat('sk-SK', {timeZoneName: 'long'});
  const dayNumber = document.querySelector('#daynumber');
  const weekNumber = document.querySelector('#weeknumber');
  const yearNumber = document.querySelector('#yearnumber');
  const timeZone = document.querySelector('#timezone');
  const current = document.querySelector('#current');
  const internetTime = document.querySelector('#internettime');

  function getISOWeekNumber(calendarDate) {
    const thursday = new Date(calendarDate);
    const weekday = (thursday.getUTCDay() + 6) % 7;
    thursday.setUTCDate(thursday.getUTCDate() + 3 - weekday);
    const startOfYear = Date.UTC(thursday.getUTCFullYear(), 0, 1);
    return Math.ceil(((thursday.getTime() - startOfYear) / dayMs + 1) / 7);
  }

  function updateDateTime() {
    const now = new Date();
    const year = now.getFullYear();
    // Use local calendar fields on a UTC grid so daylight saving cannot shorten a day.
    const calendarDate = Date.UTC(year, now.getMonth(), now.getDate());
    const bielTime = new Date(now.getTime() + hourMs); // Swatch Internet Time uses UTC+1 year-round.
    const seconds = bielTime.getUTCHours() * 3600 + bielTime.getUTCMinutes() * 60 + bielTime.getUTCSeconds();
    const beats = Math.floor(seconds / 86.4);

    dayNumber.textContent = 1 + (calendarDate - Date.UTC(year, 0, 1)) / dayMs;
    weekNumber.textContent = getISOWeekNumber(calendarDate);
    yearNumber.textContent = year;
    timeZone.textContent = timeZoneFormat.format(now);
    current.textContent = dateTimeFormat.format(now);
    internetTime.textContent = `@${beats.toString().padStart(3, '0')}`;
  }

  updateDateTime();
  setInterval(updateDateTime, 1000);
})();
