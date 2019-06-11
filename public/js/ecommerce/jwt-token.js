jQuery(($) => {
    // Onclick function to "Biblioteca virtual" button
    $('#go-to-sws, .hmenu #item-44').on('click', (e) => {

        e.preventDefault();

        const email = $('meta[name="user-email"]').attr('content').replace(/ /g, '');
        let redirect = 'https://online.amolca.com';

        if(email != '0') {
            // Create token with user email
            let token = CreateToken( email );
            redirect = 'http://mailsws.com.ve/amolca/web/api/autoLogin/' + token;
        }

        window.open(redirect, '_blank');

    });

});

// Base64 Encode function
function base64url(source) {
  // Encode in classical base64
  encodedSource = CryptoJS.enc.Base64.stringify(source);

  // Remove padding equal characters
  encodedSource = encodedSource.replace(/=+$/, '');

  // Replace characters according to base64url specifications
  encodedSource = encodedSource.replace(/\+/g, '-');
  encodedSource = encodedSource.replace(/\//g, '_');

  return encodedSource;
}

// Create token with email
const CreateToken = (email) => {

    // Defining our token parts
    let header = {
      "alg": "HS256",
      "typ": "JWT"
    };

    let data = {
      "email": email
    };

    let secret = "secreto";

    let stringifiedHeader = CryptoJS.enc.Utf8.parse(JSON.stringify(header));
    let encodedHeader = base64url(stringifiedHeader);

    let stringifiedData = CryptoJS.enc.Utf8.parse(JSON.stringify(data));
    let encodedData = base64url(stringifiedData);

    let signature = encodedHeader + "." + encodedData;
    signature = CryptoJS.HmacSHA256(signature, secret);
    signature = base64url(signature);

    return encodedHeader + '.' + encodedData + '.' + signature;
}
