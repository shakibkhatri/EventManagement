$(function(){
    $('a#logout').click(function(){
        if(confirm('Are you sure to logout')) {
            return true;
        }

        return false;
    });
});

