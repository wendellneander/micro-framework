<?php

return [
    [ '/', 'HomeController@index' ],
    [ '/posts', 'PostController@index' ],
    [ '/posts/{id}/show', 'PostController@show' ]
];
