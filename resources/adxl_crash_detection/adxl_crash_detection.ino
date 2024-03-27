#include <Wire.h>
#include <Adafruit_Sensor.h>    // Adafruit sensor library
#include <Adafruit_ADXL345_U.h>  // ADXL345 library

Adafruit_ADXL345_Unified accel = Adafruit_ADXL345_Unified();   // ADXL345 Object

// Define a threshold for crash detection (in m/s^2)
const float crashThreshold = 13.0;  // Adjust this value based on your requirements

/*
The value of crashThreshold determines how sensitive the crash detection will be:

    Higher values mean that only more intense accelerations are recognized as crashes, making the system less sensitive to minor bumps or movements.
    Lower values make the system more sensitive, so even relatively small accelerations might be considered as crashes.
*/
void setup() {
  Serial.begin(9600);
  if(!accel.begin())   // if ASXL345 sensor not found
  {
    Serial.println("ADXL345 not detected");
    while(1);
  }
  // Optionally, set the range to increase sensitivity
  accel.setRange(ADXL345_RANGE_16_G);
}

void loop() {
  sensors_event_t event;
  accel.getEvent(&event);

  // Calculate the magnitude of the acceleration vector
  // Magnitude = sqrt(x^2 + y^2 + z^2)
  float magnitude = sqrt(pow(event.acceleration.x, 2) + pow(event.acceleration.y, 2) + pow(event.acceleration.z, 2));

  Serial.print("Acceleration Magnitude: ");
  Serial.print(magnitude);
  Serial.println(" m/s^2");

  // Check if the magnitude exceeds the crash threshold
  if(magnitude > crashThreshold) {
    Serial.println("Crash detected!");
    // Implement additional crash handling logic here
  }

  delay(500);
}
