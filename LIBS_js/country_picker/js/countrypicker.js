$(function () {
    var countries = [
        {
            "name": "Afghanistan",
            "val_i": "9",
            "code": "AF"
    },
        {
            "name": "Åland Islands",
            "val_i": "10",
            "code": "AX"
    },
        {
            "name": "Albania",
            "val_i": "11",
            "code": "AL"
    },
        {
            "name": "Algeria",
            "val_i": "12",
            "code": "DZ"
    },
        {
            "name": "American Samoa",
            "val_i": "13",
            "code": "AS"
    },
        {
            "name": "Andorra",
            "val_i": "14",
            "code": "AD"
    },
        {
            "name": "Angola",
            "val_i": "15",
            "code": "AO"
    },
        {
            "name": "Anguilla",
            "val_i": "16",
            "code": "AI"
    },
        {
            "name": "Antarctica",
            "val_i": "17",
            "code": "AQ"
    },
        {
            "name": "Antigua and Barbuda",
            "val_i": "18",
            "code": "AG"
    },
        {
            "name": "Argentina",
            "val_i": "2",
            "code": "AR"
    },
        {
            "name": "Armenia",
            "val_i": "19",
            "code": "AM"
    },
        {
            "name": "Aruba",
            "val_i": "20",
            "code": "AW"
    },
        {
            "name": "Australia",
            "val_i": "21",
            "code": "AU"
    },
        {
            "name": "Austria",
            "val_i": "22",
            "code": "AT"
    },
        {
            "name": "Azerbaijan",
            "val_i": "23",
            "code": "AZ"
    },
        {
            "name": "Bahamas",
            "val_i": "24",
            "code": "BS"
    },
        {
            "name": "Bahrain",
            "val_i": "25",
            "code": "BH"
    },
        {
            "name": "Bangladesh",
            "val_i": "26",
            "code": "BD"
    },
        {
            "name": "Barbados",
            "val_i": "27",
            "code": "BB"
    },
        {
            "name": "Belarus",
            "val_i": "28",
            "code": "BY"
    },
        {
            "name": "Belgium",
            "val_i": "29",
            "code": "BE"
    },
        {
            "name": "Belize",
            "val_i": "30",
            "code": "BZ"
    },
        {
            "name": "Benin",
            "val_i": "31",
            "code": "BJ"
    },
        {
            "name": "Bermuda",
            "val_i": "32",
            "code": "BM"
    },
        {
            "name": "Bhutan",
            "val_i": "33",
            "code": "BT"
    },
        {
            "name": "Bolivia",
            "val_i": "34",
            "code": "BO"
    },
        {
            "name": "Bosnia and Herzegovina",
            "val_i": "35",
            "code": "BA"
    },
        {
            "name": "Botswana",
            "val_i": "36",
            "code": "BW"
    },
        {
            "name": "Bouvet Island",
            "val_i": "37",
            "code": "BV"
    },
        {
            "name": "Brazil",
            "val_i": "3",
            "code": "BR"
    },
        {
            "name": "British Indian Ocean Territory",
            "val_i": "38",
            "code": "IO"
    },
        {
            "name": "Brunei Darussalam",
            "val_i": "39",
            "code": "BN"
    },
        {
            "name": "Bulgaria",
            "val_i": "40",
            "code": "BG"
    },
        {
            "name": "Burkina Faso",
            "val_i": "41",
            "code": "BF"
    },
        {
            "name": "Burundi",
            "val_i": "42",
            "code": "BI"
    },
        {
            "name": "Cambodia",
            "val_i": "43",
            "code": "KH"
    },
        {
            "name": "Cameroon",
            "val_i": "44",
            "code": "CM"
    },
        {
            "name": "Canada",
            "val_i": "45",
            "code": "CA"
    },
        {
            "name": "Cape Verde",
            "val_i": "46",
            "code": "CV"
    },
        {
            "name": "Cayman Islands",
            "val_i": "47",
            "code": "KY"
    },
        {
            "name": "Central African Republic",
            "val_i": "48",
            "code": "CF"
    },
        {
            "name": "Chad",
            "val_i": "49",
            "code": "TD"
    },
        {
            "name": "Chile",
            "val_i": "1",
            "code": "CL"
    },
        {
            "name": "China",
            "val_i": "8",
            "code": "CN"
    },
        {
            "name": "Christmas Island",
            "val_i": "50",
            "code": "CX"
    },
        {
            "name": "Cocos (Keeling) Islands",
            "val_i": "51",
            "code": "CC"
    },
        {
            "name": "Colombia",
            "val_i": "52",
            "code": "CO"
    },
        {
            "name": "Comoros",
            "val_i": "53",
            "code": "KM"
    },
        {
            "name": "Congo",
            "val_i": "54",
            "code": "CG"
    },
        {
            "name": "Congo, The Democratic Republic of the",
            "val_i": "55",
            "code": "CD"
    },
        {
            "name": "Cook Islands",
            "val_i": "56",
            "code": "CK"
    },
        {
            "name": "Costa Rica",
            "val_i": "57",
            "code": "CR"
    },
        {
            "name": "Cote D\"Ivoire",
            "val_i": "58",
            "code": "CI"
    },
        {
            "name": "Croatia",
            "val_i": "59",
            "code": "HR"
    },
        {
            "name": "Cuba",
            "val_i": "60",
            "code": "CU"
    },
        {
            "name": "Cyprus",
            "val_i": "61",
            "code": "CY"
    },
        {
            "name": "Czech Republic",
            "val_i": "62",
            "code": "CZ"
    },
        {
            "name": "Denmark",
            "val_i": "63",
            "code": "DK"
    },
        {
            "name": "Djibouti",
            "val_i": "64",
            "code": "DJ"
    },
        {
            "name": "Dominica",
            "val_i": "65",
            "code": "DM"
    },
        {
            "name": "Dominican Republic",
            "val_i": "66",
            "code": "DO"
    },
        {
            "name": "Ecuador",
            "val_i": "67",
            "code": "EC"
    },
        {
            "name": "Egypt",
            "val_i": "68",
            "code": "EG"
    },
        {
            "name": "El Salvador",
            "val_i": "69",
            "code": "SV"
    },
        {
            "name": "Equatorial Guinea",
            "val_i": "70",
            "code": "GQ"
    },
        {
            "name": "Eritrea",
            "val_i": "71",
            "code": "ER"
    },
        {
            "name": "Estonia",
            "val_i": "72",
            "code": "EE"
    },
        {
            "name": "Ethiopia",
            "val_i": "73",
            "code": "ET"
    },
        {
            "name": "Falkland Islands (Malvinas)",
            "val_i": "74",
            "code": "FK"
    },
        {
            "name": "Faroe Islands",
            "val_i": "75",
            "code": "FO"
    },
        {
            "name": "Fiji",
            "val_i": "76",
            "code": "FJ"
    },
        {
            "name": "Finland",
            "val_i": "77",
            "code": "FI"
    },
        {
            "name": "France",
            "val_i": "78",
            "code": "FR"
    },
        {
            "name": "French Guiana",
            "val_i": "79",
            "code": "GF"
    },
        {
            "name": "French Polynesia",
            "val_i": "80",
            "code": "PF"
    },
        {
            "name": "French Southern Territories",
            "val_i": "81",
            "code": "TF"
    },
        {
            "name": "Gabon",
            "val_i": "82",
            "code": "GA"
    },
        {
            "name": "Gambia",
            "val_i": "83",
            "code": "GM"
    },
        {
            "name": "Georgia",
            "val_i": "84",
            "code": "GE"
    },
        {
            "name": "Alemania",
            "val_i": "7",
            "code": "DE"
    },
        {
            "name": "Ghana",
            "val_i": "85",
            "code": "GH"
    },
        {
            "name": "Gibraltar",
            "val_i": "86",
            "code": "GI"
    },
        {
            "name": "Greece",
            "val_i": "87",
            "code": "GR"
    },
        {
            "name": "Greenland",
            "val_i": "88",
            "code": "GL"
    },
        {
            "name": "Grenada",
            "val_i": "89",
            "code": "GD"
    },
        {
            "name": "Guadeloupe",
            "val_i": "90",
            "code": "GP"
    },
        {
            "name": "Guam",
            "val_i": "91",
            "code": "GU"
    },
        {
            "name": "Guatemala",
            "val_i": "92",
            "code": "GT"
    },
        {
            "name": "Guernsey",
            "val_i": "93",
            "code": "GG"
    },
        {
            "name": "Guinea",
            "val_i": "94",
            "code": "GN"
    },
        {
            "name": "Guinea-Bissau",
            "val_i": "95",
            "code": "GW"
    },
        {
            "name": "Guyana",
            "val_i": "96",
            "code": "GY"
    },
        {
            "name": "Haiti",
            "val_i": "97",
            "code": "HT"
    },
        {
            "name": "Heard Island and Mcdonald Islands",
            "val_i": "98",
            "code": "HM"
    },
        {
            "name": "Holy See (Vatican City State)",
            "val_i": "99",
            "code": "VA"
    },
        {
            "name": "Honduras",
            "val_i": "100",
            "code": "HN"
    },
        {
            "name": "Hong Kong",
            "val_i": "101",
            "code": "HK"
    },
        {
            "name": "Hungary",
            "val_i": "102",
            "code": "HU"
    },
        {
            "name": "Iceland",
            "val_i": "103",
            "code": "IS"
    },
        {
            "name": "India",
            "val_i": "104",
            "code": "IN"
    },
        {
            "name": "Indonesia",
            "val_i": "105",
            "code": "ID"
    },
        {
            "name": "Iran, Islamic Republic Of",
            "val_i": "106",
            "code": "IR"
    },
        {
            "name": "Iraq",
            "val_i": "107",
            "code": "IQ"
    },
        {
            "name": "Ireland",
            "val_i": "108",
            "code": "IE"
    },
        {
            "name": "Isle of Man",
            "val_i": "109",
            "code": "IM"
    },
        {
            "name": "Israel",
            "val_i": "110",
            "code": "IL"
    },
        {
            "name": "Italy",
            "val_i": "111",
            "code": "IT"
    },
        {
            "name": "Jamaica",
            "val_i": "112",
            "code": "JM"
    },
        {
            "name": "Japan",
            "val_i": "113",
            "code": "JP"
    },
        {
            "name": "Jersey",
            "val_i": "114",
            "code": "JE"
    },
        {
            "name": "Jordan",
            "val_i": "115",
            "code": "JO"
    },
        {
            "name": "Kazakhstan",
            "val_i": "116",
            "code": "KZ"
    },
        {
            "name": "Kenya",
            "val_i": "117",
            "code": "KE"
    },
        {
            "name": "Kiribati",
            "val_i": "118",
            "code": "KI"
    },
        {
            "name": "Korea, Democratic People\"S Republic of",
            "val_i": "119",
            "code": "KP"
    },
        {
            "name": "Korea, Republic of",
            "val_i": "120",
            "code": "KR"
    },
        {
            "name": "Kuwait",
            "val_i": "121",
            "code": "KW"
    },
        {
            "name": "Kyrgyzstan",
            "val_i": "122",
            "code": "KG"
    },
        {
            "name": "Lao People\"S Democratic Republic",
            "val_i": "123",
            "code": "LA"
    },
        {
            "name": "Latvia",
            "val_i": "124",
            "code": "LV"
    },
        {
            "name": "Lebanon",
            "val_i": "125",
            "code": "LB"
    },
        {
            "name": "Lesotho",
            "val_i": "126",
            "code": "LS"
    },
        {
            "name": "Liberia",
            "val_i": "127",
            "code": "LR"
    },
        {
            "name": "Libyan Arab Jamahiriya",
            "val_i": "128",
            "code": "LY"
    },
        {
            "name": "Liechtenstein",
            "val_i": "129",
            "code": "LI"
    },
        {
            "name": "Lithuania",
            "val_i": "130",
            "code": "LT"
    },
        {
            "name": "Luxembourg",
            "val_i": "131",
            "code": "LU"
    },
        {
            "name": "Macao",
            "val_i": "132",
            "code": "MO"
    },
        {
            "name": "Macedonia, The Former Yugoslav Republic of",
            "val_i": "133",
            "code": "MK"
    },
        {
            "name": "Madagascar",
            "val_i": "134",
            "code": "MG"
    },
        {
            "name": "Malawi",
            "val_i": "135",
            "code": "MW"
    },
        {
            "name": "Malaysia",
            "val_i": "136",
            "code": "MY"
    },
        {
            "name": "Maldives",
            "val_i": "137",
            "code": "MV"
    },
        {
            "name": "Mali",
            "val_i": "138",
            "code": "ML"
    },
        {
            "name": "Malta",
            "val_i": "139",
            "code": "MT"
    },
        {
            "name": "Marshall Islands",
            "val_i": "140",
            "code": "MH"
    },
        {
            "name": "Martinique",
            "val_i": "141",
            "code": "MQ"
    },
        {
            "name": "Mauritania",
            "val_i": "142",
            "code": "MR"
    },
        {
            "name": "Mauritius",
            "val_i": "143",
            "code": "MU"
    },
        {
            "name": "Mayotte",
            "val_i": "144",
            "code": "YT"
    },
        {
            "name": "Mexico",
            "val_i": "145",
            "code": "MX"
    },
        {
            "name": "Micronesia, Federated States of",
            "val_i": "146",
            "code": "FM"
    },
        {
            "name": "Moldova, Republic of",
            "val_i": "147",
            "code": "MD"
    },
        {
            "name": "Monaco",
            "val_i": "148",
            "code": "MC"
    },
        {
            "name": "Mongolia",
            "val_i": "149",
            "code": "MN"
    },
        {
            "name": "Montserrat",
            "val_i": "150",
            "code": "MS"
    },
        {
            "name": "Morocco",
            "val_i": "151",
            "code": "MA"
    },
        {
            "name": "Mozambique",
            "val_i": "152",
            "code": "MZ"
    },
        {
            "name": "Myanmar",
            "val_i": "153",
            "code": "MM"
    },
        {
            "name": "Namibia",
            "val_i": "154",
            "code": "NA"
    },
        {
            "name": "Nauru",
            "val_i": "155",
            "code": "NR"
    },
        {
            "name": "Nepal",
            "val_i": "156",
            "code": "NP"
    },
        {
            "name": "Netherlands",
            "val_i": "157",
            "code": "NL"
    },
        {
            "name": "Netherlands Antilles",
            "val_i": "158",
            "code": "AN"
    },
        {
            "name": "New Caledonia",
            "val_i": "159",
            "code": "NC"
    },
        {
            "name": "New Zealand",
            "val_i": "160",
            "code": "NZ"
    },
        {
            "name": "Nicaragua",
            "val_i": "161",
            "code": "NI"
    },
        {
            "name": "Niger",
            "val_i": "162",
            "code": "NE"
    },
        {
            "name": "Nigeria",
            "val_i": "163",
            "code": "NG"
    },
        {
            "name": "Niue",
            "val_i": "164",
            "code": "NU"
    },
        {
            "name": "Norfolk Island",
            "val_i": "165",
            "code": "NF"
    },
        {
            "name": "Northern Mariana Islands",
            "val_i": "166",
            "code": "MP"
    },
        {
            "name": "Norway",
            "val_i": "167",
            "code": "NO"
    },
        {
            "name": "Oman",
            "val_i": "168",
            "code": "OM"
    },
        {
            "name": "Pakistan",
            "val_i": "169",
            "code": "PK"
    },
        {
            "name": "Palau",
            "val_i": "170",
            "code": "PW"
    },
        {
            "name": "Palestinian Territory, Occupied",
            "val_i": "171",
            "code": "PS"
    },
        {
            "name": "Panama",
            "val_i": "172",
            "code": "PA"
    },
        {
            "name": "Papua New Guinea",
            "val_i": "173",
            "code": "PG"
    },
        {
            "name": "Paraguay",
            "val_i": "174",
            "code": "PY"
    },
        {
            "name": "Peru",
            "val_i": "4",
            "code": "PE"
    },
        {
            "name": "Philippines",
            "val_i": "175",
            "code": "PH"
    },
        {
            "name": "Pitcairn",
            "val_i": "176",
            "code": "PN"
    },
        {
            "name": "Poland",
            "val_i": "177",
            "code": "PL"
    },
        {
            "name": "Portugal",
            "val_i": "178",
            "code": "PT"
    },
        {
            "name": "Puerto Rico",
            "val_i": "179",
            "code": "PR"
    },
        {
            "name": "Qatar",
            "val_i": "180",
            "code": "QA"
    },
        {
            "name": "Reunion",
            "val_i": "181",
            "code": "RE"
    },
        {
            "name": "Romania",
            "val_i": "182",
            "code": "RO"
    },
        {
            "name": "Russian Federation",
            "val_i": "183",
            "code": "RU"
    },
        {
            "name": "RWANDA",
            "val_i": "184",
            "code": "RW"
    },
        {
            "name": "Saint Helena",
            "val_i": "185",
            "code": "SH"
    },
        {
            "name": "Saint Kitts and Nevis",
            "val_i": "186",
            "code": "KN"
    },
        {
            "name": "Saint Lucia",
            "val_i": "187",
            "code": "LC"
    },
        {
            "name": "Saint Pierre and Miquelon",
            "val_i": "188",
            "code": "PM"
    },
        {
            "name": "Saint Vincent and the Grenadines",
            "val_i": "189",
            "code": "VC"
    },
        {
            "name": "Samoa",
            "val_i": "190",
            "code": "WS"
    },
        {
            "name": "San Marino",
            "val_i": "191",
            "code": "SM"
    },
        {
            "name": "Sao Tome and Principe",
            "val_i": "192",
            "code": "ST"
    },
        {
            "name": "Saudi Arabia",
            "val_i": "193",
            "code": "SA"
    },
        {
            "name": "Senegal",
            "val_i": "194",
            "code": "SN"
    },
        {
            "name": "Serbia",
            "val_i": "195",
            "code": "RS"
    },
        {
            "name": "Montenegro",
            "val_i": "196",
            "code": "ME"
    },
        {
            "name": "Seychelles",
            "val_i": "197",
            "code": "SC"
    },
        {
            "name": "Sierra Leone",
            "val_i": "198",
            "code": "SL"
    },
        {
            "name": "Singapore",
            "val_i": "199",
            "code": "SG"
    },
        {
            "name": "Slovakia",
            "val_i": "200",
            "code": "SK"
    },
        {
            "name": "Slovenia",
            "val_i": "201",
            "code": "SI"
    },
        {
            "name": "Solomon Islands",
            "val_i": "202",
            "code": "SB"
    },
        {
            "name": "Somalia",
            "val_i": "203",
            "code": "SO"
    },
        {
            "name": "South Africa",
            "val_i": "204",
            "code": "ZA"
    },
        {
            "name": "South Georgia and the South Sandwich Islands",
            "val_i": "205",
            "code": "GS"
    },
        {
            "name": "Spain",
            "val_i": "206",
            "code": "ES"
    },
        {
            "name": "Sri Lanka",
            "val_i": "207",
            "code": "LK"
    },
        {
            "name": "Sudan",
            "val_i": "208",
            "code": "SD"
    },
        {
            "name": "Suriname",
            "val_i": "209",
            "code": "SR"
    },
        {
            "name": "Svalbard and Jan Mayen",
            "val_i": "210",
            "code": "SJ"
    },
        {
            "name": "Swaziland",
            "val_i": "211",
            "code": "SZ"
    },
        {
            "name": "Sweden",
            "val_i": "212",
            "code": "SE"
    },
        {
            "name": "Switzerland",
            "val_i": "213",
            "code": "CH"
    },
        {
            "name": "Syrian Arab Republic",
            "val_i": "214",
            "code": "SY"
    },
        {
            "name": "Taiwan, Province of China",
            "val_i": "215",
            "code": "TW"
    },
        {
            "name": "Tajikistan",
            "val_i": "216",
            "code": "TJ"
    },
        {
            "name": "Tanzania, United Republic of",
            "val_i": "217",
            "code": "TZ"
    },
        {
            "name": "Thailand",
            "val_i": "218",
            "code": "TH"
    },
        {
            "name": "Timor-Leste",
            "val_i": "219",
            "code": "TL"
    },
        {
            "name": "Togo",
            "val_i": "220",
            "code": "TG"
    },
        {
            "name": "Tokelau",
            "val_i": "221",
            "code": "TK"
    },
        {
            "name": "Tonga",
            "val_i": "222",
            "code": "TO"
    },
        {
            "name": "Trinidad and Tobago",
            "val_i": "223",
            "code": "TT"
    },
        {
            "name": "Tunisia",
            "val_i": "224",
            "code": "TN"
    },
        {
            "name": "Turkey",
            "val_i": "225",
            "code": "TR"
    },
        {
            "name": "Turkmenistan",
            "val_i": "226",
            "code": "TM"
    },
        {
            "name": "Turks and Caicos Islands",
            "val_i": "227",
            "code": "TC"
    },
        {
            "name": "Tuvalu",
            "val_i": "228",
            "code": "TV"
    },
        {
            "name": "Uganda",
            "val_i": "229",
            "code": "UG"
    },
        {
            "name": "Ukraine",
            "val_i": "230",
            "code": "UA"
    },
        {
            "name": "United Arab Emirates",
            "val_i": "231",
            "code": "AE"
    },
        {
            "name": "United Kingdom",
            "val_i": "232",
            "code": "GB"
    },
        {
            "name": "EEUU",
            "val_i": "5",
            "code": "US"
    },
        {
            "name": "United States Minor Outlying Islands",
            "val_i": "233",
            "code": "UM"
    },
        {
            "name": "Uruguay",
            "val_i": "6",
            "code": "UY"
    },
        {
            "name": "Uzbekistan",
            "val_i": "234",
            "code": "UZ"
    },
        {
            "name": "Vanuatu",
            "val_i": "235",
            "code": "VU"
    },
        {
            "name": "Venezuela",
            "val_i": "236",
            "code": "VE"
    },
        {
            "name": "Viet Nam",
            "val_i": "237",
            "code": "VN"
    },
        {
            "name": "Virgin Islands, British",
            "val_i": "238",
            "code": "VG"
    },
        {
            "name": "Virgin Islands, U.S.",
            "val_i": "239",
            "code": "VI"
    },
        {
            "name": "Wallis and Futuna",
            "val_i": "240",
            "code": "WF"
    },
        {
            "name": "Western Sahara",
            "val_i": "241",
            "code": "EH"
    },
        {
            "name": "Yemen",
            "val_i": "242",
            "code": "YE"
    },
        {
            "name": "Zambia",
            "val_i": "243",
            "code": "ZM"
    },
        {
            "name": "Zimbabwe",
            "val_i": "244",
            "code": "ZW"
    }
]

    var countryInput = $(document).find('.countrypicker');
    var countryList = "";
    


    //set defaults
    for (i = 0; i < countryInput.length; i++) {

        //check if flag
        flag = countryInput.eq(i).data('flag');
        
        if (flag) {
            countryList = "";
            
            //for each build list with flag
            $.each(countries, function (index, country) {
                var flagIcon = domain_val + "/LIB_assets/img/flags/" + country.code.toLowerCase() + ".png";
                countryList += "<option data-country-code='" + country.code + "' data-tokens='" + country.code + " " + country.name + "' style='padding-left:25px; background-position: 4px 7px; background-image:url(" + flagIcon + ");background-repeat:no-repeat;' value='" + country.val_i + "'>" + country.name + "</option>";
            });

            //add flags to button
            countryInput.eq(i).on('loaded.bs.select', function (e) {
                var button = $(this).closest('.btn-group').children('.btn');
                button.hide();
                var def = $(this).find(':selected').data('country-code');
                var flagIcon = domain_val + "/LIB_assets/img/flags/" + def.toLowerCase() + ".png";
                button.css("background-size", '20px');
                button.css("background-position", '10px 9px');
                button.css("padding-left", '40px');
                button.css("background-repeat", 'no-repeat');
                button.css("background-image", "url('" + flagIcon + "'");
                button.show();
            });

            //change flag on select change
            countryInput.eq(i).on('change', function () {
                button = $(this).closest('.btn-group').children('.btn');
                def = $(this).find(':selected').data('country-code');
                flagIcon = domain_val + "/LIB_assets/img/flags/" + def.toLowerCase() + ".png";
                button.css("background-size", '20px');
                button.css("background-position", '10px 9px');
                button.css("padding-left", '40px');
                button.css("background-repeat", 'no-repeat');
                button.css("background-image", "url('" + flagIcon + "'");

            });
        }else{
            countryList ="";
            
            //for each build list without flag
            $.each(countries, function (index, country) {
                countryList += "<option data-country-code='" + country.code + "' data-tokens='" + country.code + " " + country.name + "' value='" + country.val_i + "'>" + country.name + "</option>";
            });
            
            
        }
        
        datat = "<option data-country-code='none' data-tokens='' value=''>Seleccione una opcion</option>";
        datat += countryList;
        
        countryInput.eq(i).html(datat);
        //append country list
        //countryInput.eq(i).html(countryList);


        //check if default
        def = countryInput.eq(i).data('default');
        //if there's a default, set it
        if (def) {
            countryInput.eq(i).val(def);
        }


    }



});
