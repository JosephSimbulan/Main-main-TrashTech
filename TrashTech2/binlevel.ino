#include <HCSR04.h>

// Define the depth of the trash bin in centimeters
const int binDepth = 26; // Full depth of the bin in centimeters

HCSR04 ultrasonic(2, 3); // Trig, Echo pins

void setup() {
  Serial.begin(9600);
}

void loop() {
  // Read distance from the sensor in centimeters
  long distance = ultrasonic.dist();

  // Determine which range the distance falls into and print the corresponding text
  if (distance >= 20 && distance <= binDepth) {
    Serial.println("Green");
      Serial.println(distance);
  } else if (distance >= 14 && distance < 20) {
    Serial.println("Yellow");
      Serial.println(distance);
  } else if (distance >= 6 && distance < 14) {
    Serial.println("Orange");
      Serial.println(distance);
  } else if (distance < 6) {
    Serial.println("Red");
     Serial.println(distance);
  } else {
    Serial.println("Out of Range"); // In case the distance is above the bin depth
      Serial.println(distance);
  }

  delay(1000); // Delay for 1 second before the next reading
}
