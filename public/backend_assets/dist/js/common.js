const BASE_URL = $("#base_url").val();

function dispayDateFormat(date)
{
    return moment(new Date(date)).format('DD MMM, YYYY');
}

function currentDate()
{
    return moment(new Date()).format('YYYY-MM-DD');
}
