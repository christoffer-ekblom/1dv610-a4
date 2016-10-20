# Login_1DV610 - Christoffer Ekblom
Interface repository for 1DV610 assignment 2 and 4

## Install instructions
### Database

1) Create a PHP-file, mysqlCredentials.php in the root dir:
```sh
<?php

namespace Model;

function getCredentials() {
    return array(
        'host' => 'your_host',
        'username' => 'your_username',
        'password' => 'your_password',
        'db' => 'Login'
    );
}
```

2) Create database table

```sh
CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `cookie` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

INSERT INTO `members` (`id`, `username`, `password`, `cookie`) VALUES
(1, 'Admin', 'Password', NULL);
```

### Project links
- Requirements https://github.com/dntoll/1dv610/blob/master/assignments/2.requirements.md
- Test cases https://github.com/dntoll/1dv610/blob/master/assignments/A2_resources/TestCases.md
- Use cases https://github.com/dntoll/1dv610/blob/master/assignments/A2_resources/UseCases.md

- Test Application With startup code http://csquiz.lnu.se:84
- Test Application With complete code http://csquiz.lnu.se:81
- TODO checklist https://trello.com/c/pkYS5UwL
- Slack channel https://coursepress.slack.com/messages/1dv610
- Automated tests Application http://csquiz.lnu.se:82
- Public web server http://fyma.se/1dv610-a2/index.php
