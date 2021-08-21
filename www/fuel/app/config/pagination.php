<?php

return array(
    'active' => 'custom',
    'custom' => array(
        'wrapper'                => "<div class=\"pager\"><ul class=\"dc_pagination dc_paginationA dc_paginationA06\">\n\t{pagination}\n</ul></div>\n",
        'first'                  => "<li class=\"first\">\n\t{link}\n</li>\n",
        'first-marker'           => "&laquo;&laquo;",
        'first-link'             => "\t\t<a href=\"{uri}\">{page}</a>\n",
        'first-inactive'         => "",
        'first-inactive-link'    => "",
        'previous'               => "<li class=\"previous\">\n\t{link}\n</li>\n",
        'previous-marker'        => "&laquo;",
        'previous-link'          => "\t\t<a href=\"{uri}\">{page}</a>\n",
        'previous-inactive'      => "<li class=\"previous-inactive\">\n\t{link}\n</li>\n",
        'previous-inactive-link' => "\t\t<a href=\"#\">{page}</a>\n",
        'regular'                => "<li>\n\t{link}\n</li>\n",
        'regular-link'           => "\t\t<a href=\"{uri}\">{page}</a>\n",
        'active'                 => "<li class=\"active\">\n\t{link}\n</li>\n",
        'active-link'            => "\t\t<a href=\"#\">{page}</a>\n",
        'next'                   => "<li class=\"next\">\n\t{link}\n</li>\n",
        'next-marker'            => "&raquo;",
        'next-link'              => "\t\t<a href=\"{uri}\">{page}</a>\n",
        'next-inactive'          => "<li class=\"next-inactive\">\n\t{link}\n</li>\n",
        'next-inactive-link'     => "\t\t<a href=\"#\">{page}</a>\n",
        'last'                   => "<li class=\"next\">\n\t{link}\n</li>\n",
        'last-marker'            => "&raquo;&raquo;",
        'last-link'              => "\t\t<a href=\"{uri}\">{page}</a>\n",
        'last-inactive'          => "",
        'last-inactive-link'     => "",
        'show_first'             => true,
        'show_last'              => true,
        'first-marker'           => "<<",
        'last-marker'            => ">>",
        'next-marker'            => ">",
        'previous-marker'        => "<"
    )
);
