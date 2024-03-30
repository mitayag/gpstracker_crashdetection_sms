


//SIM800L Settings -------------------------------
// Please select the corresponding model
// #define SIM800L_IP5306_VERSION_20190610  
#define SIM800L_AXP192_VERSION_20200327
// #define SIM800C_AXP192_VERSION_20200609
// #define SIM800L_IP5306_VERSION_20200811

// Define the serial console for debug prints, if needed
#define DUMP_AT_COMMANDS
#define TINY_GSM_DEBUG          SerialMon
#include "utilities.h"
//SIM800L Settings -------------------------------


//ADXL345 Settings  ----------------------
#include <Wire.h>
#include <Adafruit_Sensor.h>    // Adafruit sensor library
#include <Adafruit_ADXL345_U.h>  // ADXL345 library

Adafruit_ADXL345_Unified accel = Adafruit_ADXL345_Unified();   // ADXL345 Object

// Define a threshold for crash detection (in m/s^2)
const float crashThreshold = 13.0;  // Adjust this value based on your requirements
//ADXL345 Settings  ----------------------




// Set serial for debug console (to the Serial Monitor, default speed 115200)
#define SerialMon Serial
// Set serial for AT commands (to the module)
#define SerialAT  Serial1

// Configure TinyGSM library
#define TINY_GSM_MODEM_SIM800          // Modem is SIM800
#define TINY_GSM_RX_BUFFER      1024   // Set RX buffer to 1Kb

#include <TinyGsmClient.h>
#include <TinyGPSPlus.h>


#ifdef DUMP_AT_COMMANDS
#include <StreamDebugger.h>
StreamDebugger debugger(SerialAT, SerialMon);
TinyGsm modem(debugger);
#else
TinyGsm modem(SerialAT);
#endif

// Set phone numbers, if you want to test SMS and Calls
#define SMS_TARGET  "+639923008195"
#define CALL_TARGET "+639923008195"



TinyGsmClient client(modem);


TinyGPSPlus gps;


// Your GPRS credentials (leave empty, if not needed)
const char apn[]      = "internet.globe.com.ph"; // APN for Globe
//const char apn[]      = "smartbro"; // APN for SMART
const char gprsUser[] = ""; // GPRS User
const char gprsPass[] = ""; // GPRS Password

// SIM card PIN (leave empty, if not defined)
const char simPIN[]   = ""; 

// Server details
// The server variable can be just a domain name or it can have a subdomain. It depends on the service you are using
const char server[] = "smarthelmet.cloud"; // domain name: example.com, maker.ifttt.com, etc
const char resource[] = "/request/post_data.php";         // resource path, for example: /post-data.php
const int  port = 80;                             // server port number

// Keep this API Key value to be compatible with the PHP code provided in the project page. 
// If you change the apiKeyValue value, the PHP file /post-data.php also needs to have the same key 
String apiKeyValue = "tPmAT5Ab3j7F9";
String deviceID ="001";

String gpslatitude;
String gpslongitude;



// Variables for storing GPS Data
float latitude;
float longitude;
float speed;
float satellites;
String direction;

//Set to TRUE to send SMS
bool SendSMS=true;

void setup()
{
    // Set console baud rate
    SerialMon.begin(115200);
    

    delay(10);

    // Start power management
    if (setupPMU() == false) {
        Serial.println("Setting power error");
    }

    // Some start operations
    setupModem();

    // Set GSM module baud rate and UART pins
    SerialAT.begin(115200, SERIAL_8N1, MODEM_RX, MODEM_TX);   //For SIM800L Modem
    Serial2.begin(9600, SERIAL_8N1, 32, 33); // Start serial communication with GPS on pins 32 (RX) and 33 (TX)
    
    Serial.begin(9600);
    if(!accel.begin())   // if ASXL345 sensor not found
    {
      Serial.println("ADXL345 not detected");
      while(1);
    }
  // Optionally, set the range to increase sensitivity
    accel.setRange(ADXL345_RANGE_16_G);  
    
    
    String modemInfo = modem.getModemInfo();
    SerialMon.print("Modem: ");
    SerialMon.println(modemInfo);


    delay(6000);
    SerialMon.println("AT+CMGF=1"); // Set SMS text mode
    delay(100);

    SerialMon.print("Waiting for network...");
    if (!modem.waitForNetwork(240000L)) {
      SerialMon.println(" fail");
      delay(10000);
      return;
    }
    SerialMon.println(" OK");

    if (modem.isNetworkConnected()) {
      SerialMon.println("Network connected");
    }
    
    
}

void loop()
{
    // Restart takes quite some time
    // To skip it, call init() instead of restart()
    
    //SerialMon.println("Initializing modem...");
    //modem.init();


    sensors_event_t event;
    accel.getEvent(&event);
 // Calculate the magnitude of the acceleration vector
  // Magnitude = sqrt(x^2 + y^2 + z^2)
    float magnitude = sqrt(pow(event.acceleration.x, 2) + pow(event.acceleration.y, 2) + pow(event.acceleration.z, 2));

    Serial.print("Acceleration Magnitude: ");
    Serial.print(magnitude);
    Serial.println(" m/s^2");

    //Check if the magnitude exceeds the crash threshold

    if(magnitude > crashThreshold) {
            Serial.println("Crash detected!");
            // Implement additional crash handling logic here
            
            String staticMapsUrl = "Notice: Phil Telco Blocks All SMS with Link.\nCopy the Coordinate directly to your Google Map\n\nAlert: Crash Detected\nLocation at: ";
            SendCrashDetection();
            delay(5000);



          //********************************
          SerialMon.print("Connecting to APN: ");
            SerialMon.print(apn);
            if (!modem.gprsConnect(apn, gprsUser, gprsPass)) {
              SerialMon.println(" fail");
            }
            else {
              SerialMon.println(" OK");
              
              SerialMon.print("Connecting to ");
              SerialMon.print(server);
              if (!client.connect(server, port)) {
                SerialMon.println(" fail");
              }
              else {
                SerialMon.println(" OK");
              
                // Making an HTTP POST request
                SerialMon.println("Performing HTTP POST request...");
                // Prepare your HTTP POST request data (Temperature in Celsius degrees)
                //String httpRequestData = "api_key=" + apiKeyValue + "&value1=" + String("This is a test data") + "";


                  // String httpRequestData = "api_key=" + apiKeyValue + "&value1=" + String("15.133233337038554, 120.59010755649273")
                  //                       + "&value2=" + String("15.133233337038554") + "&value3=" + String("120.59010755649273") + "&value4=" + String("02/01/2024") + "&value5=" + String("time") + "";


                 String httpRequestData = "api_key=" + apiKeyValue 
                                    + "&value1=" + "15.133233337038554, 120.59010755649273"
                                    + "&value2=" + gpslatitude
                                    + "&value3=" + gpslongitude 
                                    + "&value4=" + "02/01/2024" 
                                    + "&value5=" + "time" 
                                    + "&value6=" + deviceID;

      

              
                client.print(String("POST ") + resource + " HTTP/1.1\r\n");
                client.print(String("Host: ") + server + "\r\n");
                client.println("Connection: close");
                client.println("Content-Type: application/x-www-form-urlencoded");
                client.print("Content-Length: ");
                client.println(httpRequestData.length());
                client.println();
                client.println(httpRequestData);

                unsigned long timeout = millis();
                while (client.connected() && millis() - timeout < 10000L) {
                  // Print available data (HTTP response from server)
                  while (client.available()) {
                    char c = client.read();
                    SerialMon.print(c);
                    timeout = millis();
                  }
                }

              
                // Close client and disconnect
                client.stop();
                SerialMon.println(F("Server disconnected"));
                modem.gprsDisconnect();
                SerialMon.println(F("GPRS disconnected"));


            
              }
            }   

          //********************************
            
    }
  
    delay(500);
    

}

void SendCrashDetection() {
  while (Serial2.available() > 0) {
    //displayInfo();
    if (gps.encode(Serial2.read())) {
      if (gps.location.isValid()) {
        Serial.print("Latitude: ");
        Serial.println(gps.location.lat(), 6);

        Serial.print("Longitude: ");
        Serial.println(gps.location.lng(), 6);

        double latitude = gps.location.lat();
        double longitude = gps.location.lng();

        gpslatitude= String(latitude,6);
        gpslongitude= String(longitude, 6);



        String staticMapsUrl = "Notice: Phil Telco Blocks All SMS with Link.\nCopy the Coordinate directly to your Google Map\n\nAlert: Crash Detected\nGPS Location at: "  ;
        
        //Note: For HTTP Link
        //String mapsUrl = "https://www.google.com/maps/?q=";
        //String mapsUrl = "Location : ";
        //mapsUrl += String(latitude, 6) + "," + String(longitude, 6);

        staticMapsUrl += String(latitude, 6);
        staticMapsUrl += ",";
        staticMapsUrl += String(longitude, 6);;
        
        Serial.print(staticMapsUrl);

        if (SendSMS==true) {
          bool  locationsent = modem.sendSMS(SMS_TARGET, staticMapsUrl);
          DBG("SMS:", locationsent ? "OK" : "fail"); 
        }        
        

        delay(5000);
        break;

      } else {
        Serial.println("Waiting for GPS signal...");
      }
    }
  }

  
}

void checkGPS()
{
  if (gps.charsProcessed() < 10)
  {
    Serial.println(F("No GPS detected: check wiring."));
    //Blynk.virtualWrite(V4, "GPS ERROR");
  }  else {
    displayInfo();
  }


}

void displayInfo()
{

  if (gps.encode(Serial2.read())) {
      if (gps.location.isValid()) {
        latitude = (gps.location.lat(),6);     //Storing the Lat. and Lon.
        longitude = (gps.location.lng(),6);
        Serial.print("Latitude: ");
        Serial.println(gps.location.lat(), 6);
        Serial.print("Longitude: ");
        Serial.println(gps.location.lng(), 6);


        String MapsLocation = String(latitude) +","+ String(longitude);
        bool  locationsent = modem.sendSMS(SMS_TARGET, MapsLocation);
        DBG("SMS:", locationsent ? "OK" : "fail");
      } else {
        Serial.println("Waiting for GPS signal...");
      }
    }
  //Serial.println();
}
