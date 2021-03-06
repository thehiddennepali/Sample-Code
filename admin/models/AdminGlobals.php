<?php
class AdminGlobals extends CActiveRecord {
    const CLIENT_CODE_LENGTH    = 10;
    const PREPAID_PASSWD_LENGTH = 10;

    const DUE_DAYS_PERIOD       = 5;

    static $subscriptionStatuses = array("pending"      => "pending",
                                         "trial"        => "trial",
                                         "active"       => "active",
                                         "suspended"    => "suspended",
                                         "expired"      => "expired");

    /* Currencies */
    static $currencies = array(
                "AED"    => array("name" => "United Arab Emirates Dirham", "visible" => 0),
                "AFN"    => array("name" => "Afghan Afghani", "visible" => 0),
                "ALL"    => array("name" => "Albanian Lek", "visible" => 0),
                "AMD"    => array("name" => "Armenian Dram", "visible" => 0),
                "AOA"    => array("name" => "Angolan Kwanza", "visible" => 0),
                "ARS"    => array("name" => "Argentine Peso", "visible" => 8),
                "AUD"    => array("name" => "Australian Dollar", "visible" => 0),
                "AWG"    => array("name" => "Aruban Florin", "visible" => 0),
                "AZN"    => array("name" => "Azerbaijani Manat", "visible" => 0),
                "BAM"    => array("name" => "Bosnia and Herzegovina Convertible Mark", "visible" => 0),
                "BBD"    => array("name" => "Barbadian Dollar", "visible" => 0),
                "BDT"    => array("name" => "Bangladeshi Taka", "visible" => 0),
                "BGN"    => array("name" => "Bulgarian Lev", "visible" => 0),
                "BHD"    => array("name" => "Bahraini Dinar", "visible" => 0),
                "BIF"    => array("name" => "Burundian Franc", "visible" => 0),
                "BMD"    => array("name" => "Bermudian Dollar", "visible" => 0),
                "BND"    => array("name" => "Brunei Dollar", "visible" => 0),
                "BOB"    => array("name" => "Bolivian Boliviano", "visible" => 0),
                "BRL"    => array("name" => "Brazilian Real", "visible" => 0),
                "BSD"    => array("name" => "Bahamian Dollar", "visible" => 0),
                "BTN"    => array("name" => "Bhutanese Ngultrum", "visible" => 0),
                "BWP"    => array("name" => "Botswana Pula", "visible" => 0),
                "BYR"    => array("name" => "Belarusian Ruble", "visible" => 0),
                "BZD"    => array("name" => "Belize Dollar", "visible" => 0),
                "CAD"    => array("name" => "Canadian Dollar", "visible" => 0),
                "CDF"    => array("name" => "Congolese Franc", "visible" => 0),
                "CHF"    => array("name" => "Swiss Franc", "visible" => 0),
                "CLP"    => array("name" => "Chilean Peso", "visible" => 0),
                "CNY"    => array("name" => "Chinese Yuan", "visible" => 0),
                "COP"    => array("name" => "Colombian Peso", "visible" => 0),
                "CRC"    => array("name" => "Costa Rican Colon", "visible" => 0),
                "CUP"    => array("name" => "Cuban convertible Peso", "visible" => 0),
                "CVE"    => array("name" => "Cape Verdean Escudo", "visible" => 0),
                "CZK"    => array("name" => "Czech Koruna", "visible" => 0),
                "DJF"    => array("name" => "Djiboutian Franc", "visible" => 0),
                "DKK"    => array("name" => "Danish Krone", "visible" => 0),
                "DOP"    => array("name" => "Dominican Peso", "visible" => 0),
                "DZD"    => array("name" => "Algerian Dinar", "visible" => 0),
                "EGP"    => array("name" => "Egyptian Pound", "visible" => 0),
                "ERN"    => array("name" => "Eritrean Nakfa", "visible" => 0),
                "ETB"    => array("name" => "Ethiopian Birr", "visible" => 0),
                "EUR"    => array("name" => "Euro", "visible" => 1),
                "FJD"    => array("name" => "Fijian Dollar", "visible" => 0),
                "FKP"    => array("name" => "Falkland Islands Pound", "visible" => 0),
                "GBP"    => array("name" => "British Pound", "visible" => 1),
                "GEL"    => array("name" => "Georgian Lari", "visible" => 0),
                "GHS"    => array("name" => "Ghana Cedi", "visible" => 0),
                "GMD"    => array("name" => "Gambian Dalasi", "visible" => 0),
                "GNF"    => array("name" => "Guinean Franc", "visible" => 0),
                "GTQ"    => array("name" => "Guatemalan Quetzal", "visible" => 0),
                "GYD"    => array("name" => "Guyanese Dollar", "visible" => 0),
                "HKD"    => array("name" => "Hong Kong Dollar", "visible" => 0),
                "HNL"    => array("name" => "Honduran Lempira", "visible" => 0),
                "HRK"    => array("name" => "Croatian Kuna", "visible" => 0),
                "HTG"    => array("name" => "Haitian Gourde", "visible" => 0),
                "HUF"    => array("name" => "Hungarian Forint", "visible" => 0),
                "IDR"    => array("name" => "Indonesian Rupiah", "visible" => 0),
                "ILS"    => array("name" => "Israeli New Shekel", "visible" => 0),
                "IMP"    => array("name" => "Manx Pound", "visible" => 0),
                "INR"    => array("name" => "Indian Rupee", "visible" => 0),
                "IQD"    => array("name" => "Iraqi Dinar", "visible" => 0),
                "IRR"    => array("name" => "Iranian Rial", "visible" => 0),
                "ISK"    => array("name" => "Icelandic Krona", "visible" => 0),
                "JEP"    => array("name" => "Jersey Pound", "visible" => 0),
                "JMD"    => array("name" => "Jamaican Dollar", "visible" => 0),
                "JOD"    => array("name" => "Jordanian Dinar", "visible" => 0),
                "JPY"    => array("name" => "Japanese Yen", "visible" => 0),
                "KES"    => array("name" => "Kenyan Shilling", "visible" => 0),
                "KGS"    => array("name" => "Kyrgyzstani Som", "visible" => 0),
                "KHR"    => array("name" => "Cambodian Riel", "visible" => 0),
                "KMF"    => array("name" => "Comorian Franc", "visible" => 0),
                "KPW"    => array("name" => "North Korean Won", "visible" => 0),
                "KRW"    => array("name" => "South Korean Won", "visible" => 0),
                "KWD"    => array("name" => "Kuwaiti Dinar", "visible" => 0),
                "KYD"    => array("name" => "Cayman Islands Dollar", "visible" => 0),
                "KZT"    => array("name" => "Kazakhstani Tenge", "visible" => 0),
                "LAK"    => array("name" => "Lao Kip", "visible" => 0),
                "LBP"    => array("name" => "Lebanese Pound", "visible" => 0),
                "LKR"    => array("name" => "Sri Lankan Rupee", "visible" => 0),
                "LRD"    => array("name" => "Liberian Dollar", "visible" => 0),
                "LSL"    => array("name" => "Lesotho Loti", "visible" => 0),
                "LTL"    => array("name" => "Lithuanian Litas", "visible" => 0),
                "LVL"    => array("name" => "Latvian Lats", "visible" => 0),
                "LYD"    => array("name" => "Libyan Dinar", "visible" => 0),
                "MAD"    => array("name" => "Moroccan Dirham", "visible" => 0),
                "MDL"    => array("name" => "Moldovan Leu", "visible" => 0),
                "MGA"    => array("name" => "Malagasy Ariary", "visible" => 0),
                "MKD"    => array("name" => "Macedonian Denar", "visible" => 0),
                "MMK"    => array("name" => "Burmese Kyat", "visible" => 0),
                "MNT"    => array("name" => "Mongolian Togrog", "visible" => 0),
                "MOP"    => array("name" => "Macanese Pataca", "visible" => 0),
                "MRO"    => array("name" => "Mauritanian Ouguiya", "visible" => 0),
                "MUR"    => array("name" => "Mauritian Rupee", "visible" => 0),
                "MVR"    => array("name" => "Maldivian Rufiyaa", "visible" => 0),
                "MWK"    => array("name" => "Malawian Kwacha", "visible" => 0),
                "MXN"    => array("name" => "Mexican Peso", "visible" => 0),
                "MYR"    => array("name" => "Malaysian Ringgit", "visible" => 0),
                "MZN"    => array("name" => "Mozambican Metical", "visible" => 0),
                "NAD"    => array("name" => "Namibian Dollar", "visible" => 0),
                "NGN"    => array("name" => "Nigerian Naira", "visible" => 0),
                "NIO"    => array("name" => "Nicaraguan Cordoba", "visible" => 0),
                "NOK"    => array("name" => "Norwegian Krone", "visible" => 0),
                "NPR"    => array("name" => "Nepalese Rupee", "visible" => 0),
                "NZD"    => array("name" => "New Zealand Dollar", "visible" => 0),
                "OMR"    => array("name" => "Omani Rial", "visible" => 0),
                "PAB"    => array("name" => "Panamanian Balboa", "visible" => 0),
                "PEN"    => array("name" => "Peruvian Nuevo Sol", "visible" => 0),
                "PGK"    => array("name" => "Papua New Guinean Kina", "visible" => 0),
                "PHP"    => array("name" => "Philippine Peso", "visible" => 0),
                "PKR"    => array("name" => "Pakistani Rupee", "visible" => 0),
                "PLN"    => array("name" => "Polish Zloty", "visible" => 0),
                "PRB"    => array("name" => "Transnistrian Ruble", "visible" => 0),
                "PYG"    => array("name" => "Paraguayan Guaraní", "visible" => 0),
                "QAR"    => array("name" => "Qatari Riyal", "visible" => 0),
                "RON"    => array("name" => "Romanian Leu", "visible" => 0),
                "RSD"    => array("name" => "Serbian Dinar", "visible" => 0),
                "RUB"    => array("name" => "Russian Ruble", "visible" => 0),
                "RWF"    => array("name" => "Rwandan Franc", "visible" => 0),
                "SAR"    => array("name" => "Saudi Riyal", "visible" => 0),
                "SBD"    => array("name" => "Solomon Islands Dollar", "visible" => 0),
                "SCR"    => array("name" => "Seychellois Rupee", "visible" => 0),
                "SEK"    => array("name" => "Swedish Krona", "visible" => 0),
                "SGD"    => array("name" => "Singapore Dollar", "visible" => 0),
                "SHP"    => array("name" => "Saint Helena Pound", "visible" => 0),
                "SLL"    => array("name" => "Sierra Leonean Leone", "visible" => 0),
                "SOS"    => array("name" => "Somali Shilling", "visible" => 0),
                "SRD"    => array("name" => "Surinamese Dollar", "visible" => 0),
                "SSP"    => array("name" => "South Sudanese Pound", "visible" => 0),
                "SVC"    => array("name" => "Salvadoran Colón", "visible" => 0),
                "SYP"    => array("name" => "Syrian Pound", "visible" => 0),
                "SZL"    => array("name" => "Swazi Lilangeni", "visible" => 0),
                "THB"    => array("name" => "Thai Baht", "visible" => 0),
                "TJS"    => array("name" => "Tajikistani Somoni", "visible" => 0),
                "TMT"    => array("name" => "Turkmenistan Manat", "visible" => 0),
                "TND"    => array("name" => "Tunisian Dinar", "visible" => 0),
                "TRY"    => array("name" => "Turkish Lira", "visible" => 0),
                "TTD"    => array("name" => "Trinidad And Tobago Dollar", "visible" => 0),
                "TWD"    => array("name" => "New Taiwan Dollar", "visible" => 0),
                "TZS"    => array("name" => "Tanzanian Shilling", "visible" => 0),
                "UAH"    => array("name" => "Ukrainian Hryvnia", "visible" => 0),
                "UGX"    => array("name" => "Ugandan Shilling", "visible" => 0),
                "USD"    => array("name" => "United States Dollar", "visible" => 1),
                "UYU"    => array("name" => "Uruguayan Peso", "visible" => 0),
                "UZS"    => array("name" => "Uzbekistani Som", "visible" => 0),
                "VEF"    => array("name" => "Venezuelan Bolívar", "visible" => 0),
                "VND"    => array("name" => "Vietnamese Dong", "visible" => 0),
                "VUV"    => array("name" => "Vanuatu Vatu", "visible" => 0),
                "WST"    => array("name" => "Samoan Tala", "visible" => 0),
                "XAF"    => array("name" => "Central African CFA Franc", "visible" => 0),
                "XCD"    => array("name" => "East Caribbean Dollar", "visible" => 0),
                "XOF"    => array("name" => "West African CFA Franc", "visible" => 0),
                "XPF"    => array("name" => "CFP Franc", "visible" => 0),
                "YER"    => array("name" => "Yemeni Rial", "visible" => 0),
                "ZAR"    => array("name" => "South African Rand", "visible" => 0),
                "ZMW"    => array("name" => "Zambian Kwacha", "visible" => 0),
                "ZWL"    => array("name" => "Zimbabwean Dollar", "visible" => 0),
        );

    /* Time Zone */
    static $timezones = array(
                "Pacific/Midway"                    => "(GMT-11:00) Midway Island, Samoa",
                "America/Adak"                      => "(GMT-10:00) Hawaii-Aleutian",
                "Etc/GMT+10"                        => "(GMT-10:00) Hawaii",
                "Pacific/Marquesas"                 => "(GMT-09:30) Marquesas Islands",
                "Pacific/Gambier"                   => "(GMT-09:00) Gambier Islands",
                "America/Anchorage"                 => "(GMT-09:00) Alaska",
                "America/Ensenada"                  => "(GMT-08:00) Tijuana, Baja California",
                "Etc/GMT+8"                         => "(GMT-08:00) Pitcairn Islands",
                "America/Los_Angeles"               => "(GMT-08:00) Pacific Time (US & Canada)",
                "America/Denver"                    => "(GMT-07:00) Mountain Time (US & Canada)",
                "America/Chihuahua"                 => "(GMT-07:00) Chihuahua, La Paz, Mazatlan",
                "America/Dawson_Creek"              => "(GMT-07:00) Arizona",
                "America/Belize"                    => "(GMT-06:00) Saskatchewan, Central America",
                "America/Cancun"                    => "(GMT-06:00) Guadalajara, Mexico City, Monterrey",
                "Chile/EasterIsland"                => "(GMT-06:00) Easter Island",
                "America/Chicago"                   => "(GMT-06:00) Central Time (US & Canada)",
                "America/New_York"                  => "(GMT-05:00) Eastern Time (US & Canada)",
                "America/Havana"                    => "(GMT-05:00) Cuba",
                "America/Bogota"                    => "(GMT-05:00) Bogota, Lima, Quito, Rio Branco",
                "America/Caracas"                   => "(GMT-04:30) Caracas",
                "America/Santiago"                  => "(GMT-04:00) Santiago",
                "America/La_Paz"                    => "(GMT-04:00) La Paz",
                "Atlantic/Stanley"                  => "(GMT-04:00) Faukland Islands",
                "America/Campo_Grande"              => "(GMT-04:00) Brazil",
                "America/Goose_Bay"                 => "(GMT-04:00) Atlantic Time (Goose Bay)",
                "America/Glace_Bay"                 => "(GMT-04:00) Atlantic Time (Canada)",
                "America/St_Johns"                  => "(GMT-03:30) Newfoundland",
                "America/Araguaina"                 => "(GMT-03:00) UTC-3",
                "America/Montevideo"                => "(GMT-03:00) Montevideo",
                "America/Miquelon"                  => "(GMT-03:00) Miquelon, St. Pierre",
                "America/Godthab"                   => "(GMT-03:00) Greenland",
                "America/Argentina/Buenos_Aires"    => "(GMT-03:00) Buenos Aires",
                "America/Sao_Paulo"                 => "(GMT-03:00) Brasilia",
                "America/Noronha"                   => "(GMT-02:00) Mid-Atlantic",
                "Atlantic/Cape_Verde"               => "(GMT-01:00) Cape Verde Is.",
                "Atlantic/Azores"                   => "(GMT-01:00) Azores",
                "Europe/Belfast"                    => "(GMT) Greenwich Mean Time : Belfast",
                "Europe/Dublin"                     => "(GMT) Greenwich Mean Time : Dublin",
                "Europe/Lisbon"                     => "(GMT) Greenwich Mean Time : Lisbon",
                "Europe/London"                     => "(GMT) Greenwich Mean Time : London",
                "Africa/Abidjan"                    => "(GMT) Monrovia, Reykjavik",
                "Europe/Amsterdam"                  => "(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna",
                "Europe/Belgrade"                   => "(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague",
                "Europe/Brussels"                   => "(GMT+01:00) Brussels, Copenhagen, Madrid, Paris",
                "Africa/Algiers"                    => "(GMT+01:00) West Central Africa",
                "Africa/Windhoek"                   => "(GMT+01:00) Windhoek",
                "Asia/Beirut"                       => "(GMT+02:00) Beirut",
                "Africa/Cairo"                      => "(GMT+02:00) Cairo",
                "Asia/Gaza"                         => "(GMT+02:00) Gaza",
                "Africa/Blantyre"                   => "(GMT+02:00) Harare, Pretoria",
                "Asia/Jerusalem"                    => "(GMT+02:00) Jerusalem",
                "Europe/Minsk"                      => "(GMT+02:00) Minsk",
                "Asia/Damascus"                     => "(GMT+02:00) Syria",
                "Europe/Moscow"                     => "(GMT+03:00) Moscow, St. Petersburg, Volgograd",
                "Africa/Addis_Ababa"                => "(GMT+03:00) Nairobi",
                "Asia/Tehran"                       => "(GMT+03:30) Tehran",
                "Asia/Dubai"                        => "(GMT+04:00) Abu Dhabi, Muscat",
                "Asia/Yerevan"                      => "(GMT+04:00) Yerevan",
                "Asia/Kabul"                        => "(GMT+04:30) Kabul",
                "Asia/Yekaterinburg"                => "(GMT+05:00) Ekaterinburg",
                "Asia/Tashkent"                     => "(GMT+05:00) Tashkent",
                "Asia/Kolkata"                      => "(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi",
                "Asia/Katmandu"                     => "(GMT+05:45) Kathmandu",
                "Asia/Dhaka"                        => "(GMT+06:00) Astana, Dhaka",
                "Asia/Novosibirsk"                  => "(GMT+06:00) Novosibirsk",
                "Asia/Rangoon"                      => "(GMT+06:30) Yangon (Rangoon)",
                "Asia/Bangkok"                      => "(GMT+07:00) Bangkok, Hanoi, Jakarta",
                "Asia/Krasnoyarsk"                  => "(GMT+07:00) Krasnoyarsk",
                "Asia/Hong_Kong"                    => "(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi",
                "Asia/Irkutsk"                      => "(GMT+08:00) Irkutsk, Ulaan Bataar",
                "Australia/Perth"                   => "(GMT+08:00) Perth",
                "Australia/Eucla"                   => "(GMT+08:45) Eucla",
                "Asia/Tokyo"                        => "(GMT+09:00) Osaka, Sapporo, Tokyo",
                "Asia/Seoul"                        => "(GMT+09:00) Seoul",
                "Asia/Yakutsk"                      => "(GMT+09:00) Yakutsk",
                "Australia/Adelaide"                => "(GMT+09:30) Adelaide",
                "Australia/Darwin"                  => "(GMT+09:30) Darwin",
                "Australia/Brisbane"                => "(GMT+10:00) Brisbane",
                "Australia/Hobart"                  => "(GMT+10:00) Hobart",
                "Asia/Vladivostok"                  => "(GMT+10:00) Vladivostok",
                "Australia/Lord_Howe"               => "(GMT+10:30) Lord Howe Island",
                "Etc/GMT-11"                        => "(GMT+11:00) Solomon Is., New Caledonia",
                "Asia/Magadan"                      => "(GMT+11:00) Magadan",
                "Pacific/Norfolk"                   => "(GMT+11:30) Norfolk Island",
                "Asia/Anadyr"                       => "(GMT+12:00) Anadyr, Kamchatka",
                "Pacific/Auckland"                  => "(GMT+12:00) Auckland, Wellington",
                "Etc/GMT-12"                        => "(GMT+12:00) Fiji, Kamchatka, Marshall Is.",
                "Pacific/Chatham"                   => "(GMT+12:45) Chatham Islands",
                "Pacific/Tongatapu"                 => "(GMT+13:00) Nuku'alofa",
                "Pacific/Kiritimati"                => "(GMT+14:00) Kiritimati",
            );

    /* Roles */
    static $actionsInfo = array("Manage"=>array("Users"=>array("manage/users/admin"   => "List",
                                                               "manage/users/view"    => "View",
                                                               "manage/users/create"  => "Create",
                                                               "manage/users/update"  => "Update",
                                                               "manage/users/delete"  => "Delete"),

                                                "Block Mac"=>array("manage/blockMac/admin"    => "List",
                                                                   "manage/blockMac/view"     => "View",
                                                                   "manage/blockMac/create"   => "Create",
                                                                   "manage/blockMac/update"   => "Update",
                                                                   "manage/blockMac/delete"   => "Delete"),
					),
                                "Hotspot"=>array("Property"=>array("hotspot/property/admin"     => "List",
                                                                   "hotspot/property/view"      => "View",
                                                                   "hotspot/property/create"    => "Create",
                                                                   "hotspot/property/update"    => "Update",
                                                                   "hotspot/property/delete"    => "Delete"),

                                                  "Property Groups"=>array("hotspot/propertyGroups/admin"   => "List",
                                                                           "hotspot/propertyGroups/view"    => "View",
                                                                           "hotspot/propertyGroups/create"  => "Create",
                                                                           "hotspot/propertyGroups/update"  => "Update",
                                                                           "hotspot/propertyGroups/delete"  => "Delete"),

                                                  "NAS"=>array("hotspot/nas/admin"  => "List",
                                                               "hotspot/nas/view"   => "View",
                                                               "hotspot/nas/create" => "Create",
                                                               "hotspot/nas/update" => "Update",
                                                               "hotspot/nas/delete" => "Delete"),
                                            ),
			    	          "Monitoring"=>array("Devices"=>array("monitoring/devices/admin"     => "List",
                                                                   "monitoring/devices/view"      => "View",
                                                                   "monitoring/devices/create"    => "Create",
                                                                   "monitoring/devices/update"    => "Update",
                                                                   "monitoring/devices/delete"    => "Delete"),

                                                  "Settings"=>array("monitoring/monitoringSettings/update"   => "Update"),

                                            ),
                        "Billing"=>array("Payment Gateways"=>array("billing/paymentGateways/admin"     => "List",
                                                                   "billing/paymentGateways/view"      => "View",
                                                                   "billing/paymentGateways/create"    => "Create",
                                                                   "billing/paymentGateways/update"    => "Update",
                                                                   "billing/paymentGateways/delete"    => "Delete"),
						
                        "Plan Groups"=>array("billing/planGroups/admin"   => "List",
                                             "billing/planGroups/view"    => "View",
                                             "billing/planGroups/create"  => "Create",
                                             "billing/planGroups/update"  => "Update",
                                             "billing/planGroups/delete"  => "Delete"),

						"Plans"=>array("billing/plans/admin"   => "List",
                                       "billing/plans/view"    => "View",
                                       "billing/plans/create"  => "Create",
                                       "billing/plans/update"  => "Update",
                                       "billing/plans/delete"  => "Delete"),

						"Transactions"=>array("billing/transactions/admin"      => "List",
                                              "billing/transactions/view"       => "View",
                                              "billing/transactions/refund"     => "Refunds",
									          "billing/transactions/viewRefund" => "View Refund Transaction"),

						"Prepaid Batch"=>array("billing/prepaidBatch/admin"             => "List",
                                               "billing/prepaidBatch/view"              => "View",
                                               "billing/prepaidBatch/create"            => "Create",
                                               "billing/prepaidBatch/update"            => "Update",
                                               "billing/prepaidBatch/delete"            => "Delete",
                                               "billing/prepaidBatch/listPrepaids"      => "List Prepaid Cards",
                                               "billing/prepaidBatch/export"            => "Export",
                                               "billing/prepaidExportTemplates/admin"   => "List Templates",
                                               "billing/prepaidExportTemplates/view"    => "View Template",
                                               "billing/prepaidExportTemplates/create"  => "Create Template",
                                               "billing/prepaidExportTemplates/update"  => "Update Template",
                                               "billing/prepaidExportTemplates/delete"  => "Delete Template"),


                                            ),
				"Helpdesk"=>array("Tickets"=>array("helpdesk/tickets/admin"     => "List",
                                                   "helpdesk/tickets/view"      => "View",
                                                   "helpdesk/tickets/create"    => "Create",
                                                   "helpdesk/tickets/update"    => "Update",
                                                   "helpdesk/tickets/delete"    => "Delete"),
						
						"Categories"=>array("helpdesk/categories/admin" => "List",
                                       "helpdesk/categories/view"       => "View",
                                       "helpdesk/categories/create"     => "Create",
                                       "helpdesk/categories/update"     => "Update",
                                       "helpdesk/categories/delete"     => "Delete"),

						"Email Templates"=>array("helpdesk/emailTemplates/admin"   => "List",
                                                                           "helpdesk/emailTemplates/view"    => "View",
                                                                           "helpdesk/emailTemplates/create"  => "Create",
                                                                           "helpdesk/emailTemplates/update"  => "Update",
                                                                           "helpdesk/emailTemplates/delete"  => "Delete"),
				    ),
				    "Admin"=>array("Role Groups"=>array("admin/roleGroups/admin/"     => "List",
                                                        "admin/roleGroups/view"      => "View",
                                                        "admin/roleGroups/create"    => "Create",
                                                        "admin/roleGroups/update"    => "Update",
								                        "admin/roleGroups/delete"    => "Delete"),
				    		
				    		"Accounts"=>array("admin/accounts/admin"   => "List",
                                              "admin/accounts/view"    => "View",
                                              "admin/accounts/create"  => "Create",
                                              "admin/accounts/update"  => "Update",
									          "admin/accounts/delete"  => "Delete"),

						"Login History"=>array("admin/accounts/admin" => "List"),
			    ),

                            );

    /* If user is authenticated allow this actions without checking the rolegroup permissions. */
    static $authAllowedActions = array("dashboard/index",
                                       "dashboard/addNewWidget",
                                       "dashboard/removeWidget",
				       "dashboard/saveChanges",
				       /* Dashboard Widgets*/
				       "widget/bandwidthUsage",
				       "widget/loginFailures",
				       "widget/currentOutages",
				       "widget/recentTickets",
				       "widget/recentSignups",
				       "widget/activeSessions",
				       "widget/revenuePerProperty",
				       "widget/ticketsPerProperty",
				       "widget/recentPrepaidBatches",
				       "widget/recentTransactions",
				       "widget/usersPerProperty",
				       /*AJAX Auto Complete*/
				       "helpdesk/tickets/getRegisteredUserData",
				       "helpdesk/tickets/getSelectedUserData",
				       "helpdesk/tickets/getAdditionalInfo",
                                      );

    static function getCurrencies() {
        $arr = array();
        foreach(self::$currencies as $key => $val) {
            if($val["visible"] ===1) {
                $arr[$key] = $val["name"];
            }
        }
        array_multisort($arr);
        return $arr;
    }

    static function getTimeZones() {
        return self::$timezones;
    }

    static function getTimeZoneName($timezone) {
        return self::$timezones[$timezone];
    }

    static function getSubscriptionStatuses() {
        return self::$subscriptionStatuses;
    }

    static function getActionsInfo() {
        return self::$actionsInfo;
    }

    static function getAuthAllowedActions() {
        return self::$authAllowedActions;
    }
}
?>
