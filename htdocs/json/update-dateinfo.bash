#!/bin/bash

# Uppdaterar informationen från arbetsförmedlingens databas.
#
# Uppdaterar alla yrkesgrupper inom yrkesområdet DATA/IT och sparar ner i separata json-filer


YEAR="$1"
echo

echo -e "\e[39m*************************************************** DATEINFO ***************************************************"
echo
echo "Försöker ladda ner information för $YEAR"

echo

echo -e "\e[39mHämtar information för - \e[96mJanuari $YEAR"
echo -e "\e[39mKontrollerar uppkoppling mot request http://api.dryg.net/dagar/v2.1/$YEAR/01"
response=$(curl --write-out "%{http_code}\n" --silent --header "Accept: application/json; charset=UTF-8" --header "Accept-Language: sv" "http://api.dryg.net/dagar/v2.1/$YEAR/01")
STATUSCODE=${response: -3} #Statuskoden på anropet
json=${response:0:-3} #Jsonobjektet från anropet (tar bort statuskoden)
echo "Status code: $STATUSCODE - http://api.dryg.net/dagar/v2.1/$YEAR/01"

if [[ $STATUSCODE -eq 200 ]]; then
    echo -e $json > januari-$YEAR.json
    echo -e "\e[92mjanuari-$YEAR.json har skapats"
else
    echo -e "\e[31mjanuari-$YEAR.json kunde inte skapas"
fi

echo

echo -e "\e[39mHämtar information för - \e[96mFebruari $YEAR"
echo -e "\e[39mKontrollerar uppkoppling mot request http://api.dryg.net/dagar/v2.1/$YEAR/02"
response=$(curl --write-out "%{http_code}\n" --silent --header "Accept: application/json; charset=UTF-8" --header "Accept-Language: sv" "http://api.dryg.net/dagar/v2.1/$YEAR/02")
STATUSCODE=${response: -3} #Statuskoden på anropet
json=${response:0:-3} #Jsonobjektet från anropet (tar bort statuskoden)
echo "Status code: $STATUSCODE - http://api.dryg.net/dagar/v2.1/$YEAR/02"

if [[ $STATUSCODE -eq 200 ]]; then
    echo -e $json > februari-$YEAR.json
    echo -e "\e[92mfebruari-$YEAR.json har skapats"
else
    echo -e "\e[31mfebruar-$YEAR.json kunde inte skapas"
fi

echo

echo -e "\e[39mHämtar information för - \e[96mMars $YEAR"
echo -e "\e[39mKontrollerar uppkoppling mot request http://api.dryg.net/dagar/v2.1/$YEAR/03"
response=$(curl --write-out "%{http_code}\n" --silent --header "Accept: application/json; charset=UTF-8" --header "Accept-Language: sv" "http://api.dryg.net/dagar/v2.1/$YEAR/03")
STATUSCODE=${response: -3} #Statuskoden på anropet
json=${response:0:-3} #Jsonobjektet från anropet (tar bort statuskoden)
echo "Status code: $STATUSCODE - http://api.dryg.net/dagar/v2.1/$YEAR/03"

if [[ $STATUSCODE -eq 200 ]]; then
    echo -e $json > mars-$YEAR.json
    echo -e "\e[92mmars-$YEAR.json har skapats"
else
    echo -e "\e[31mmars-$YEAR.json kunde inte skapas"
fi

echo

echo -e "\e[39mHämtar information för - \e[96mApril $YEAR"
echo -e "\e[39mKontrollerar uppkoppling mot request http://api.dryg.net/dagar/v2.1/$YEAR/04"
response=$(curl --write-out "%{http_code}\n" --silent --header "Accept: application/json; charset=UTF-8" --header "Accept-Language: sv" "http://api.dryg.net/dagar/v2.1/$YEAR/04")
STATUSCODE=${response: -3} #Statuskoden på anropet
json=${response:0:-3} #Jsonobjektet från anropet (tar bort statuskoden)
echo "Status code: $STATUSCODE - http://api.dryg.net/dagar/v2.1/$YEAR/04"

if [[ $STATUSCODE -eq 200 ]]; then
    echo -e $json > april-$YEAR.json
    echo -e "\e[92mapril-$YEAR.json har skapats"
else
    echo -e "\e[31mapril-$YEAR.json kunde inte skapas"
fi

echo

echo -e "\e[39mHämtar information för - \e[96mMaj $YEAR"
echo -e "\e[39mKontrollerar uppkoppling mot request http://api.dryg.net/dagar/v2.1/$YEAR/05"
response=$(curl --write-out "%{http_code}\n" --silent --header "Accept: application/json; charset=UTF-8" --header "Accept-Language: sv" "http://api.dryg.net/dagar/v2.1/$YEAR/05")
STATUSCODE=${response: -3} #Statuskoden på anropet
json=${response:0:-3} #Jsonobjektet från anropet (tar bort statuskoden)
echo "Status code: $STATUSCODE - http://api.dryg.net/dagar/v2.1/$YEAR/05"

if [[ $STATUSCODE -eq 200 ]]; then
    echo -e $json > maj-$YEAR.json
    echo -e "\e[92mmaj-$YEAR.json har skapats"
else
    echo -e "\e[31mmaj-$YEAR.json kunde inte skapas"
fi

echo

echo -e "\e[39mHämtar information för - \e[96mJuni $YEAR"
echo -e "\e[39mKontrollerar uppkoppling mot request http://api.dryg.net/dagar/v2.1/$YEAR/06"
response=$(curl --write-out "%{http_code}\n" --silent --header "Accept: application/json; charset=UTF-8" --header "Accept-Language: sv" "http://api.dryg.net/dagar/v2.1/$YEAR/06")
STATUSCODE=${response: -3} #Statuskoden på anropet
json=${response:0:-3} #Jsonobjektet från anropet (tar bort statuskoden)
echo "Status code: $STATUSCODE - http://api.dryg.net/dagar/v2.1/$YEAR/06"

if [[ $STATUSCODE -eq 200 ]]; then
    echo -e $json > juni-$YEAR.json
    echo -e "\e[92mjuni-$YEAR.json har skapats"
else
    echo -e "\e[31mjuni-$YEAR.json kunde inte skapas"
fi

echo

echo -e "\e[39mHämtar information för - \e[96mJuli $YEAR"
echo -e "\e[39mKontrollerar uppkoppling mot request http://api.dryg.net/dagar/v2.1/$YEAR/07"
response=$(curl --write-out "%{http_code}\n" --silent --header "Accept: application/json; charset=UTF-8" --header "Accept-Language: sv" "http://api.dryg.net/dagar/v2.1/$YEAR/07")
STATUSCODE=${response: -3} #Statuskoden på anropet
json=${response:0:-3} #Jsonobjektet från anropet (tar bort statuskoden)
echo "Status code: $STATUSCODE - http://api.dryg.net/dagar/v2.1/$YEAR/07"

if [[ $STATUSCODE -eq 200 ]]; then
    echo -e $json > juli-$YEAR.json
    echo -e "\e[92mjuli-$YEAR.json har skapats"
else
    echo -e "\e[31mjuli-$YEAR.json kunde inte skapas"
fi

echo

echo -e "\e[39mHämtar information för - \e[96mAugusti $YEAR"
echo -e "\e[39mKontrollerar uppkoppling mot request http://api.dryg.net/dagar/v2.1/$YEAR/08"
response=$(curl --write-out "%{http_code}\n" --silent --header "Accept: application/json; charset=UTF-8" --header "Accept-Language: sv" "http://api.dryg.net/dagar/v2.1/$YEAR/08")
STATUSCODE=${response: -3} #Statuskoden på anropet
json=${response:0:-3} #Jsonobjektet från anropet (tar bort statuskoden)
echo "Status code: $STATUSCODE - http://api.dryg.net/dagar/v2.1/$YEAR/08"

if [[ $STATUSCODE -eq 200 ]]; then
    echo -e $json > augusti-$YEAR.json
    echo -e "\e[92maugusti-$YEAR.json har skapats"
else
    echo -e "\e[31maugusti-$YEAR.json kunde inte skapas"
fi

echo

echo -e "\e[39mHämtar information för - \e[96mSeptember $YEAR"
echo -e "\e[39mKontrollerar uppkoppling mot request http://api.dryg.net/dagar/v2.1/$YEAR/09"
response=$(curl --write-out "%{http_code}\n" --silent --header "Accept: application/json; charset=UTF-8" --header "Accept-Language: sv" "http://api.dryg.net/dagar/v2.1/$YEAR/09")
STATUSCODE=${response: -3} #Statuskoden på anropet
json=${response:0:-3} #Jsonobjektet från anropet (tar bort statuskoden)
echo "Status code: $STATUSCODE - http://api.dryg.net/dagar/v2.1/$YEAR/09"

if [[ $STATUSCODE -eq 200 ]]; then
    echo -e $json > september-$YEAR.json
    echo -e "\e[92mseptember-$YEAR.json har skapats"
else
    echo -e "\e[31mseptember-$YEAR.json kunde inte skapas"
fi

echo

echo -e "\e[39mHämtar information för - \e[96mOktober $YEAR"
echo -e "\e[39mKontrollerar uppkoppling mot request http://api.dryg.net/dagar/v2.1/$YEAR/10"
response=$(curl --write-out "%{http_code}\n" --silent --header "Accept: application/json; charset=UTF-8" --header "Accept-Language: sv" "http://api.dryg.net/dagar/v2.1/$YEAR/10")
STATUSCODE=${response: -3} #Statuskoden på anropet
json=${response:0:-3} #Jsonobjektet från anropet (tar bort statuskoden)
echo "Status code: $STATUSCODE - http://api.dryg.net/dagar/v2.1/$YEAR/10"

if [[ $STATUSCODE -eq 200 ]]; then
    echo -e $json > oktober-$YEAR.json
    echo -e "\e[92moktober-$YEAR.json har skapats"
else
    echo -e "\e[31moktober-$YEAR.json kunde inte skapas"
fi

echo

echo -e "\e[39mHämtar information för - \e[96mNovember $YEAR"
echo -e "\e[39mKontrollerar uppkoppling mot request http://api.dryg.net/dagar/v2.1/$YEAR/11"
response=$(curl --write-out "%{http_code}\n" --silent --header "Accept: application/json; charset=UTF-8" --header "Accept-Language: sv" "http://api.dryg.net/dagar/v2.1/$YEAR/11")
STATUSCODE=${response: -3} #Statuskoden på anropet
json=${response:0:-3} #Jsonobjektet från anropet (tar bort statuskoden)
echo "Status code: $STATUSCODE - http://api.dryg.net/dagar/v2.1/$YEAR/11"

if [[ $STATUSCODE -eq 200 ]]; then
    echo -e $json > november-$YEAR.json
    echo -e "\e[92mnovember-$YEAR.json har skapats"
else
    echo -e "\e[31mnovember-$YEAR.json kunde inte skapas"
fi

echo

echo -e "\e[39mHämtar information för - \e[96mDecember $YEAR"
echo -e "\e[39mKontrollerar uppkoppling mot request http://api.dryg.net/dagar/v2.1/$YEAR/12"
response=$(curl --write-out "%{http_code}\n" --silent --header "Accept: application/json; charset=UTF-8" --header "Accept-Language: sv" "http://api.dryg.net/dagar/v2.1/$YEAR/12")
STATUSCODE=${response: -3} #Statuskoden på anropet
json=${response:0:-3} #Jsonobjektet från anropet (tar bort statuskoden)
echo "Status code: $STATUSCODE - http://api.dryg.net/dagar/v2.1/$YEAR/12"

if [[ $STATUSCODE -eq 200 ]]; then
    echo -e $json > december-$YEAR.json
    echo -e "\e[92mdecember-$YEAR.json har skapats"
else
    echo -e "\e[31mdecember-$YEAR.json kunde inte skapas"
fi

echo
