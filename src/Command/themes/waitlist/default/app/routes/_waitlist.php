<?php

app()->post('/waitlist', 'Waitlist\JoinController@handle');
app()->post('/waitlist/invite', 'Waitlist\InvitesController@handle');
