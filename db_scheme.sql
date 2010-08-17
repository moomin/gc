SET NAMES 'utf8';

CREATE TABLE IF NOT EXISTS geocache (
  id MEDIUMINT,
  title VARCHAR(100),
  latitude FLOAT(10,6),
  longtitude FLOAT(10,6),
  birthTimestamp TIMESTAMP,
  submitTimestamp TIMESTAMP,
  creator VARCHAR(1000),
  status TINYINT,
  cacheDescription TEXT,
  locationDescription TEXT


)