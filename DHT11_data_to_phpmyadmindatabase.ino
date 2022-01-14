#include "DHT.h"
#include <ESP8266WiFi.h>
#include <WiFiClient.h>
#include <ESP8266WebServer.h>
#include <ESP8266mDNS.h>
#include <SPI.h>
#include <MFRC522.h>

//NodeMCU 0.9(ESP-12 Module)
#define DHTPIN D4 //make sure connected correctly on the NodeMCU 

#define DHTTYPE DHT22 //change to DHT11 if using DHT11 sensor

DHT dht(DHTPIN, DHTTYPE);

float humidityData;
float temperatureData;

const char* ssid = "norizan123-Maxis Fibre";//the wifi name *must be exactly the same*
const char* password = "wrk1699910"; //wifi password
//WiFiClient client;
char server[] = "192.168.1.10";   //eg: 192.168.0.222 go to config type ipconfig and get the IPv4 address

WiFiClient client;

void setup()
{
  Serial.begin(115200); //if the serial monitor shows weird characters change the speed on the serial monitor to match this
  delay(10);
  dht.begin();
  // Connect to WiFi network
  Serial.println();
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(ssid);

  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("WiFi connected");

  // Start the server
  //  server.begin();
  Serial.println("Server started");
  Serial.print(WiFi.localIP());
  delay(1000);
  Serial.println(" connecting...");
}
void loop()
{
  humidityData = dht.readHumidity();
  temperatureData = dht.readTemperature();

  //incase nan value is retrieve
  if (!isnan(humidityData) && !isnan(temperatureData)) {
    // print value on the serial monitor
    Serial.print("Value humidity: ");
    Serial.print(humidityData);
    Serial.println(" ");
    Serial.print("Value temperature: ");
    Serial.print(temperatureData);
    Sending_To_phpmyadmindatabase();
  }
  else {
    // print value on the serial monitor
    // nan usually means it could not read migth be a wiring problem especially the D number
    Serial.println(" nan value");
    Serial.println("nanValue humidity: ");
    Serial.print(humidityData);
    Serial.println(" ");
    Serial.println("nanValue temperature: ");
    Serial.print(temperatureData);
    Serial.println(" ");
  }
  delay(60000); // interval
}

void Sending_To_phpmyadmindatabase()   //CONNECTING WITH MYSQL
{
  if (client.connect(server, 80)) { //check in XAMPP for the port number usually either 3306 or 80
    Serial.println(" ");
    Serial.println(" ");
    Serial.println("CONNECTED");
    Serial.println(" ");
    // Make a HTTP request:
    //send data using get
    Serial.print("GET /testcode2/dht11.php?humidity=");
    client.print("GET /testcode2/dht11.php?humidity=");     //YOUR URL from the file in htdocs
    Serial.println(humidityData);
    client.print(humidityData);
    client.print("&temperature=");
    Serial.println("&temperature=");
    client.print(temperatureData);
    Serial.println(temperatureData);
    Serial.println(" ");
    client.print(" ");      //SPACE BEFORE HTTP/1.1
    client.print("HTTP/1.1");
    client.println();
    client.println("Host: localhost");
    client.println("Connection: close");
    client.println();
  } else {
    // if you didn't get a connection to the server:
    // if phpmyadmin full also cannot get data
    Serial.println(" ");
    Serial.println("CONNECTION FAILED");
    Serial.println(" ");
  }
}
