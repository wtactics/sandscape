<?php

/* User.php
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2013, the Sandscape team.
 * 
 * Sandscape uses several third party libraries and resources, a complete list 
 * can be found in the <README> file and in <_dev/thirdparty/about.html>.
 * 
 * Sandscape's team members are listed in the <CONTRIBUTORS> file.
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * This is the model class for the <em>User</em> table.
 *
 * The followings are the available columns in table 'User':
 * @property int $userId
 * @property string $email
 * @property string $password
 * @property string $name
 * @property int $active
 * @property string $avatar
 * @property int $gender
 * @property string $birthyear
 * @property string $website
 * @property string $twitter
 * @property string $facebook
 * @property string $googleplus
 * @property string $skype
 * @property string country
 * @property string $role
 * @property int $reverseCards
 * @property int $onHoverDetails
 * @property int $showChatTimes
 * 
 * The followings are the available model relations:
 * @property ChatMessage[] $chatMessages
 * @property Deck[] $decks
 * @property Game[] $gamesAsPlayer1
 * @property Game[] $gamesAsPlayer2
 * @property Reward[] $rewards
 * @property Title[] $titles
 */
class User extends CActiveRecord {

    /**
     * @return User
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{User}}';
    }

    public function rules() {
        return array(
            array('email, name', 'required'),
            array('gender, reverseCards, onHoverDetails, showChatTimes', 'numerical', 'integerOnly' => true),
            array('email, avatar, website, twitter, facebook, googleplus, skype', 'length', 'max' => 255),
            array('country', 'length', 'max' => 2),
            array('name', 'length', 'max' => 150),
            array('role', 'length', 'max' => 15),
            array('email', 'email'),
            array('name, email', 'unique', 'className' => 'User'),
            //search
            array('email, name, role', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'chatMessages' => array(self::HAS_MANY, 'ChatMessage', 'userId'),
            'decks' => array(self::HAS_MANY, 'Deck', 'userId'),
            'gamesAsPlayer1' => array(self::HAS_MANY, 'Game', 'player1'),
            'gamesAsPlayer2' => array(self::HAS_MANY, 'Game', 'player2'),
            'rewards' => array(self::MANY_MANY, 'Reward', 'UserReward(userId, rewardId)'),
            'titles' => array(self::MANY_MANY, 'Title', 'UserTitle(userId, titleId)')
        );
    }

    public function attributeLabels() {
        return array(
            'userId' => Yii::t('sandscape', 'ID'),
            'email' => Yii::t('sandscape', 'E-mail'),
            'password' => Yii::t('sandscape', 'Password'),
            'name' => Yii::t('sandscape', 'Name'),
            'avatar' => Yii::t('sandscape', 'Avatar'),
            'gender' => Yii::t('sandscape', 'Gender'),
            'birthyear' => Yii::t('sandscape', 'Birth Year'),
            'website' => Yii::t('sandscape', 'Website'),
            'twitter' => Yii::t('sandscape', 'Twitter'),
            'facebook' => Yii::t('sandscape', 'Facebook'),
            'googleplus' => Yii::t('sandscape', 'Google+'),
            'skype' => Yii::t('sandscape', 'Skype'),
            'country' => Yii::t('sandscape', 'Country'),
            'reverseCards' => Yii::t('sandscape', 'Reverse Cards'),
            'onHoverDetails' => Yii::t('sandscape', 'Details On Hover'),
            'role' => Yii::t('sandscape', 'Role')
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * A filter is just an <em>Card</em> instance whose attribute values are used 
     * to limit the search criteria.
     * 
     * @return CActiveDataProvider the data provider that can return the models 
     * based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria();

        $criteria->compare('email', $this->email, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('role', $this->role);

        return new CActiveDataProvider($this, array('criteria' => $criteria));
    }

    /**
     * Retrieves all users that were active in the last 15 minutes.
     * 
     * @return CActiveDataProvider
     */
    public function findAllAuthenticated() {
        $criteria = new CDbCriteria();
        $criteria->select = 't.*';
        $criteria->join = 'INNER JOIN SessionData ON t.userId = SessionData.userId';
        $criteria->condition = 'TOKEN IS NOT NULL AND tokenExpires > NOW() AND lastActivity > DATE_SUB(NOW(), INTERVAL 15 MINUTE)';

        return new CActiveDataProvider('User', array('criteria' => $criteria));
    }

    /**
     * Creates a hash from the given password using the correct hashing process.
     * This method should be prefered over manually hashing any password.
     * 
     * @param string $password The password you whish to hash.
     * 
     * @return string The hashed password. 
     */
    public final static function hash($password) {
        return sha1($password . Yii::app()->params['hash']);
    }

    public final static function rolesArray() {
        return array(
            'administrator' => Yii::t('sandscape', 'Administrator'),
            'player' => Yii::t('sandscape', 'Player')
        );
    }

    public final function getRole() {
        $roles = self::rolesArray();

        return (isset($roles[$this->role]) ? $roles[$this->role] : '');
    }

    public final function getCountry() {
        $countries = self::countries();

        return (isset($countries[$this->country]) ? $countries[$this->country] : '');
    }

    public final function showReversedCards() {
        return $this->reverseCards ? Yii::t('sandscape', 'Yes') : Yii::t('sandscape', 'No');
    }

    public final function showDetailsOnHover() {
        return $this->onHoverDetails ? Yii::t('sandscape', 'Yes') : Yii::t('sandscape', 'No');
    }

    public final function getGender() {
        return $this->gender == 1 ? Yii::t('sandscape', 'Male') : Yii::t('sandscape', 'Female');
    }

    public final static function countries() {
        return array(
            'AD' => Yii::t('countries', 'Andorra'),
            'AE' => Yii::t('countries', 'United Arab Emirates'),
            'AF' => Yii::t('countries', 'Afghanistan'),
            'AG' => Yii::t('countries', 'Antigua and Barbuda'),
            'AI' => Yii::t('countries', 'Anguilla'),
            'AL' => Yii::t('countries', 'Albania'),
            'AM' => Yii::t('countries', 'Armenia'),
            'AO' => Yii::t('countries', 'Angola'),
            'AQ' => Yii::t('countries', 'Antarctica'),
            'AR' => Yii::t('countries', 'Argentina'),
            'AS' => Yii::t('countries', 'American Samoa'),
            'AT' => Yii::t('countries', 'Austria'),
            'AU' => Yii::t('countries', 'Australia'),
            'AW' => Yii::t('countries', 'Aruba'),
            'AX' => Yii::t('countries', 'Åland Islands'),
            'AZ' => Yii::t('countries', 'Azerbaijan'),
            'BA' => Yii::t('countries', 'Bosnia and Herzegovina'),
            'BB' => Yii::t('countries', 'Barbados'),
            'BD' => Yii::t('countries', 'Bangladesh'),
            'BE' => Yii::t('countries', 'Belgium'),
            'BF' => Yii::t('countries', 'Burkina Faso'),
            'BG' => Yii::t('countries', 'Bulgaria'),
            'BH' => Yii::t('countries', 'Bahrain'),
            'BI' => Yii::t('countries', 'Burundi'),
            'BJ' => Yii::t('countries', 'Benin'),
            'BL' => Yii::t('countries', 'Saint Barthélemy'),
            'BM' => Yii::t('countries', 'Bermuda'),
            'BN' => Yii::t('countries', 'Brunei Darussalam'),
            'BO' => Yii::t('countries', 'Bolivia, Plurinational State of'),
            'BQ' => Yii::t('countries', 'Bonaire, Sint Eustatius and Saba'),
            'BR' => Yii::t('countries', 'Brazil'),
            'BS' => Yii::t('countries', 'Bahamas'),
            'BT' => Yii::t('countries', 'Bhutan'),
            'BV' => Yii::t('countries', 'Bouvet Island'),
            'BW' => Yii::t('countries', 'Botswana'),
            'BY' => Yii::t('countries', 'Belarus'),
            'BZ' => Yii::t('countries', 'Belize'),
            'CA' => Yii::t('countries', 'Canada'),
            'CC' => Yii::t('countries', 'Cocos (Keeling) Islands'),
            'CD' => Yii::t('countries', 'Congo, the Democratic Republic of the'),
            'CF' => Yii::t('countries', 'Central African Republic'),
            'CG' => Yii::t('countries', 'Congo'),
            'CH' => Yii::t('countries', 'Switzerland'),
            'CI' => Yii::t('countries', 'Côte d\'Ivoire'),
            'CK' => Yii::t('countries', 'Cook Islands'),
            'CL' => Yii::t('countries', 'Chile'),
            'CM' => Yii::t('countries', 'Cameroon'),
            'CN' => Yii::t('countries', 'China'),
            'CO' => Yii::t('countries', 'Colombia'),
            'CR' => Yii::t('countries', 'Costa Rica'),
            'CU' => Yii::t('countries', 'Cuba'),
            'CV' => Yii::t('countries', 'Cape Verde'),
            'CW' => Yii::t('countries', 'Curaçao'),
            'CX' => Yii::t('countries', 'Christmas Island'),
            'CY' => Yii::t('countries', 'Cyprus'),
            'CZ' => Yii::t('countries', 'Czech Republic'),
            'DE' => Yii::t('countries', 'Germany'),
            'DJ' => Yii::t('countries', 'Djibouti'),
            'DK' => Yii::t('countries', 'Denmark'),
            'DM' => Yii::t('countries', 'Dominica'),
            'DO' => Yii::t('countries', 'Dominican Republic'),
            'DZ' => Yii::t('countries', 'Algeria'),
            'EC' => Yii::t('countries', 'Ecuador'),
            'EE' => Yii::t('countries', 'Estonia'),
            'EG' => Yii::t('countries', 'Egypt'),
            'EH' => Yii::t('countries', 'Western Sahara'),
            'ER' => Yii::t('countries', 'Eritrea'),
            'ES' => Yii::t('countries', 'Spain'),
            'ET' => Yii::t('countries', 'Ethiopia'),
            'FI' => Yii::t('countries', 'Finland'),
            'FJ' => Yii::t('countries', 'Fiji'),
            'FK' => Yii::t('countries', 'Falkland Islands (Malvinas)'),
            'FM' => Yii::t('countries', 'Micronesia, Federated States of'),
            'FO' => Yii::t('countries', 'Faroe Islands'),
            'FR' => Yii::t('countries', 'France'),
            'GA' => Yii::t('countries', 'Gabon'),
            'GB' => Yii::t('countries', 'United Kingdom'),
            'GD' => Yii::t('countries', 'Grenada'),
            'GE' => Yii::t('countries', 'Georgia'),
            'GF' => Yii::t('countries', 'French Guiana'),
            'GG' => Yii::t('countries', 'Guernsey'),
            'GH' => Yii::t('countries', 'Ghana'),
            'GI' => Yii::t('countries', 'Gibraltar'),
            'GL' => Yii::t('countries', 'Greenland'),
            'GM' => Yii::t('countries', 'Gambia'),
            'GN' => Yii::t('countries', 'Guinea'),
            'GP' => Yii::t('countries', 'Guadeloupe'),
            'GQ' => Yii::t('countries', 'Equatorial Guinea'),
            'GR' => Yii::t('countries', 'Greece'),
            'GS' => Yii::t('countries', 'South Georgia and the South Sandwich Islands'),
            'GT' => Yii::t('countries', 'Guatemala'),
            'GU' => Yii::t('countries', 'Guam'),
            'GW' => Yii::t('countries', 'Guinea-Bissau'),
            'GY' => Yii::t('countries', 'Guyana'),
            'HK' => Yii::t('countries', 'Hong Kong'),
            'HM' => Yii::t('countries', 'Heard Island and McDonald Islands'),
            'HN' => Yii::t('countries', 'Honduras'),
            'HR' => Yii::t('countries', 'Croatia'),
            'HT' => Yii::t('countries', 'Haiti'),
            'HU' => Yii::t('countries', 'Hungary'),
            'ID' => Yii::t('countries', 'Indonesia'),
            'IE' => Yii::t('countries', 'Ireland'),
            'IL' => Yii::t('countries', 'Israel'),
            'IM' => Yii::t('countries', 'Isle of Man'),
            'IN' => Yii::t('countries', 'India'),
            'IO' => Yii::t('countries', 'British Indian Ocean Territory'),
            'IQ' => Yii::t('countries', 'Iraq'),
            'IR' => Yii::t('countries', 'Iran, Islamic Republic of'),
            'IS' => Yii::t('countries', 'Iceland'),
            'IT' => Yii::t('countries', 'Italy'),
            'JE' => Yii::t('countries', 'Jersey'),
            'JM' => Yii::t('countries', 'Jamaica'),
            'JO' => Yii::t('countries', 'Jordan'),
            'JP' => Yii::t('countries', 'Japan'),
            'KE' => Yii::t('countries', 'Kenya'),
            'KG' => Yii::t('countries', 'Kyrgyzstan'),
            'KH' => Yii::t('countries', 'Cambodia'),
            'KI' => Yii::t('countries', 'Kiribati'),
            'KM' => Yii::t('countries', 'Comoros'),
            'KN' => Yii::t('countries', 'Saint Kitts and Nevis'),
            'KP' => Yii::t('countries', 'Korea, Democratic People\'s Republic of'),
            'KR' => Yii::t('countries', 'Korea, Republic of'),
            'KW' => Yii::t('countries', 'Kuwait'),
            'KY' => Yii::t('countries', 'Cayman Islands'),
            'KZ' => Yii::t('countries', 'Kazakhstan'),
            'LA' => Yii::t('countries', 'Lao People\'s Democratic Republic'),
            'LB' => Yii::t('countries', 'Lebanon'),
            'LC' => Yii::t('countries', 'Saint Lucia'),
            'LI' => Yii::t('countries', 'Liechtenstein'),
            'LK' => Yii::t('countries', 'Sri Lanka'),
            'LR' => Yii::t('countries', 'Liberia'),
            'LS' => Yii::t('countries', 'Lesotho'),
            'LT' => Yii::t('countries', 'Lithuania'),
            'LU' => Yii::t('countries', 'Luxembourg'),
            'LV' => Yii::t('countries', 'Latvia'),
            'LY' => Yii::t('countries', 'Libya'),
            'MA' => Yii::t('countries', 'Morocco'),
            'MC' => Yii::t('countries', 'Monaco'),
            'MD' => Yii::t('countries', 'Moldova, Republic of'),
            'ME' => Yii::t('countries', 'Montenegro'),
            'MF' => Yii::t('countries', 'Saint Martin'),
            'MG' => Yii::t('countries', 'Madagascar'),
            'MH' => Yii::t('countries', 'Marshall Islands'),
            'MK' => Yii::t('countries', 'Macedonia'),
            'ML' => Yii::t('countries', 'Mali'),
            'MM' => Yii::t('countries', 'Myanmar'),
            'MN' => Yii::t('countries', 'Mongolia'),
            'MO' => Yii::t('countries', 'Macao'),
            'MP' => Yii::t('countries', 'Northern Mariana Islands'),
            'MQ' => Yii::t('countries', 'Martinique'),
            'MR' => Yii::t('countries', 'Mauritania'),
            'MS' => Yii::t('countries', 'Montserrat'),
            'MT' => Yii::t('countries', 'Malta'),
            'MU' => Yii::t('countries', 'Mauritius'),
            'MV' => Yii::t('countries', 'Maldives'),
            'MW' => Yii::t('countries', 'Malawi'),
            'MX' => Yii::t('countries', 'Mexico'),
            'MY' => Yii::t('countries', 'Malaysia'),
            'MZ' => Yii::t('countries', 'Mozambique'),
            'NA' => Yii::t('countries', 'Namibia'),
            'NC' => Yii::t('countries', 'New Caledonia'),
            'NE' => Yii::t('countries', 'Niger'),
            'NF' => Yii::t('countries', 'Norfolk Island'),
            'NG' => Yii::t('countries', 'Nigeria'),
            'NI' => Yii::t('countries', 'Nicaragua'),
            'NL' => Yii::t('countries', 'Netherlands'),
            'NO' => Yii::t('countries', 'Norway'),
            'NP' => Yii::t('countries', 'Nepal'),
            'NR' => Yii::t('countries', 'Nauru'),
            'NU' => Yii::t('countries', 'Niue'),
            'NZ' => Yii::t('countries', 'New Zealand'),
            'OM' => Yii::t('countries', 'Oman'),
            'PA' => Yii::t('countries', 'Panama'),
            'PE' => Yii::t('countries', 'Peru'),
            'PF' => Yii::t('countries', 'French Polynesia'),
            'PG' => Yii::t('countries', 'Papua New Guinea'),
            'PH' => Yii::t('countries', 'Philippines'),
            'PK' => Yii::t('countries', 'Pakistan'),
            'PL' => Yii::t('countries', 'Poland'),
            'PM' => Yii::t('countries', 'Saint Pierre and Miquelon'),
            'PN' => Yii::t('countries', 'Pitcairn'),
            'PR' => Yii::t('countries', 'Puerto Rico'),
            'PS' => Yii::t('countries', 'Palestinian Territory'),
            'PT' => Yii::t('countries', 'Portugal'),
            'PW' => Yii::t('countries', 'Palau'),
            'PY' => Yii::t('countries', 'Paraguay'),
            'QA' => Yii::t('countries', 'Qatar'),
            'RE' => Yii::t('countries', 'Réunion'),
            'RO' => Yii::t('countries', 'Romania'),
            'RS' => Yii::t('countries', 'Serbia'),
            'RU' => Yii::t('countries', 'Russian Federation'),
            'RW' => Yii::t('countries', 'Rwanda'),
            'SA' => Yii::t('countries', 'Saudi Arabia'),
            'SB' => Yii::t('countries', 'Solomon Islands'),
            'SC' => Yii::t('countries', 'Seychelles'),
            'SD' => Yii::t('countries', 'Sudan'),
            'SE' => Yii::t('countries', 'Sweden'),
            'SG' => Yii::t('countries', 'Singapore'),
            'SH' => Yii::t('countries', 'Saint Helena, Ascension and Tristan da Cunha'),
            'SI' => Yii::t('countries', 'Slovenia'),
            'SJ' => Yii::t('countries', 'Svalbard and Jan Mayen'),
            'SK' => Yii::t('countries', 'Slovakia'),
            'SL' => Yii::t('countries', 'Sierra Leone'),
            'SM' => Yii::t('countries', 'San Marino'),
            'SN' => Yii::t('countries', 'Senegal'),
            'SO' => Yii::t('countries', 'Somalia'),
            'SR' => Yii::t('countries', 'Suriname'),
            'SS' => Yii::t('countries', 'South Sudan'),
            'ST' => Yii::t('countries', 'Sao Tome and Principe'),
            'SV' => Yii::t('countries', 'El Salvador'),
            'SX' => Yii::t('countries', 'Sint Maarten'),
            'SY' => Yii::t('countries', 'Syrian Arab Republic'),
            'SZ' => Yii::t('countries', 'Swaziland'),
            'TC' => Yii::t('countries', 'Turks and Caicos Islands'),
            'TD' => Yii::t('countries', 'Chad'),
            'TF' => Yii::t('countries', 'French Southern Territories'),
            'TG' => Yii::t('countries', 'Togo'),
            'TH' => Yii::t('countries', 'Thailand'),
            'TJ' => Yii::t('countries', 'Tajikistan'),
            'TK' => Yii::t('countries', 'Tokelau'),
            'TL' => Yii::t('countries', 'Timor-Leste'),
            'TM' => Yii::t('countries', 'Turkmenistan'),
            'TN' => Yii::t('countries', 'Tunisia'),
            'TO' => Yii::t('countries', 'Tonga'),
            'TR' => Yii::t('countries', 'Turkey'),
            'TT' => Yii::t('countries', 'Trinidad and Tobago'),
            'TV' => Yii::t('countries', 'Tuvalu'),
            'TW' => Yii::t('countries', 'Taiwan'),
            'TZ' => Yii::t('countries', 'Tanzania, United Republic of'),
            'UA' => Yii::t('countries', 'Ukraine'),
            'UG' => Yii::t('countries', 'Uganda'),
            'UM' => Yii::t('countries', 'United States Minor Outlying Islands'),
            'US' => Yii::t('countries', 'United States'),
            'UY' => Yii::t('countries', 'Uruguay'),
            'UZ' => Yii::t('countries', 'Uzbekistan'),
            'VA' => Yii::t('countries', 'Holy See (Vatican City State)'),
            'VC' => Yii::t('countries', 'Saint Vincent and the Grenadines'),
            'VE' => Yii::t('countries', 'Venezuela, Bolivarian Republic of'),
            'VG' => Yii::t('countries', 'Virgin Islands, British'),
            'VI' => Yii::t('countries', 'Virgin Islands, U.S.'),
            'VN' => Yii::t('countries', 'Viet Nam'),
            'VU' => Yii::t('countries', 'Vanuatu'),
            'WF' => Yii::t('countries', 'Wallis and Futuna'),
            'WS' => Yii::t('countries', 'Samoa'),
            'YE' => Yii::t('countries', 'Yemen'),
            'YT' => Yii::t('countries', 'Mayotte'),
            'ZA' => Yii::t('countries', 'South Africa'),
            'ZM' => Yii::t('countries', 'Zambia'),
            'ZW' => Yii::t('countries', 'Zimbabwe'),
        );
    }

}