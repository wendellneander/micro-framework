<?php

return [
    [ '/', 'WelcomeController@index' ],
    [ '/posts', 'PostController@index' ],
    [ '/posts/{id}/show', 'PostController@show' ]
];
