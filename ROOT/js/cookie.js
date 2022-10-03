//Tayla Orsmond u21467456
// Language: javascript, jquery
// Path: js\cookie.js
// Description: This is the functionality for getting cookies.

//get the cookie values 
export const get_cookie = (cookieName, cookies) => {
    const name = cookieName + "=";//beginning of cookie string (name of name value pair)
    for(const cookie of cookies){
        let c = cookie;
        while(c.charAt(0) == ' '){//parse until you get to just before a cookie name
            c = c.substring(1);
        }
        if(c.indexOf(name) == 0){//cookie name match
            return c.substring(name.length, c.length);//parse the cookie string to get value
        }
    }
    return "-1";
}