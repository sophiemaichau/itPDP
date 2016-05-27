void setup() {
  Particle.function("sendData", sendData);

  Serial.begin(9600);
  Serial1.begin(9600);
  
}


void loop() {
    // Sender Arduinos serial monitor til Photon
  if(Serial1.available())
    Serial.write(Serial1.read());
}


int sendData(String command) {
    // Sender data fra Photon til Arduino
  Serial1.println(command);
  
  // test: photon til sig selv
    Serial.println(command);
    
  return 1;
}




