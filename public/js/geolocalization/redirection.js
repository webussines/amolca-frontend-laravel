const RedirectToCountry = (href, host, domain) => {
    const redirect_key = 'hUodhTqrVuoVDTcVV1ySqv85j0dagEloAIzTe188qb4NBgyYtNl7cUniib5HZmhB';
    let redirect = href.replace(host, domain);
    let email = $('meta[name="user-email"]').attr('content').replace(/ /g, '');

    if(email != 0) {
        redirect = 'https://api.amolca.com/users/autologin?email=' + email + '&key=' + redirect_key + '&redirect_to=https://' + domain;
    }

    return redirect;
}
