CREATE TABLE Student (
    Student_ID INT AUTO_INCREMENT PRIMARY KEY,
    Student_name VARCHAR(30) NOT NULL,
    Student_username VARCHAR(30) UNIQUE,
    Student_phone VARCHAR(11) UNIQUE,
    Student_img TEXT,
    Student_year INT,
    Student_pass TEXT
);

CREATE TABLE Club (
    Club_ID INT AUTO_INCREMENT PRIMARY KEY,
    Club_name VARCHAR(30) NOT NULL,
    Club_description TEXT,
    Club_logo VARCHAR(255)
);

CREATE TABLE Event (
    Event_ID INT AUTO_INCREMENT PRIMARY KEY,
    Club_ID INT,
    Event_name VARCHAR(255),
    Event_description TEXT,
    Event_date DATE,
    Event_logo VARCHAR(255),
    FOREIGN KEY (Club_ID) REFERENCES Club(Club_ID) ON DELETE CASCADE
);

CREATE TABLE Club_member (
    Membership_ID INT AUTO_INCREMENT PRIMARY KEY,
    Student_ID INT,
    Club_ID INT,
    Member_role VARCHAR(20),
    FOREIGN KEY (Student_ID) REFERENCES Student(Student_ID) ON DELETE CASCADE,
    FOREIGN KEY (Club_ID) REFERENCES Club(Club_ID) ON DELETE CASCADE
);

CREATE TABLE Event_organizer (
    Organizer_ID INT AUTO_INCREMENT PRIMARY KEY,
    Event_ID INT,
    Membership_ID INT,
    FOREIGN KEY (Event_ID) REFERENCES Event(Event_ID) ON DELETE CASCADE,
    FOREIGN KEY (Membership_ID) REFERENCES Club_member(Membership_ID) ON DELETE CASCADE
);

CREATE TABLE Event_attendee (
    Attendant_ID INT AUTO_INCREMENT PRIMARY KEY,
    Student_ID INT NOT NULL,
    Event_ID INT NOT NULL,
    Event_eval VARCHAR(3) ,
    Event_comment TEXT NOT NULL,
    FOREIGN KEY (Student_ID) REFERENCES Student(Student_ID) ON DELETE CASCADE,
    FOREIGN KEY (Event_ID) REFERENCES Event(Event_ID) ON DELETE CASCADE
);

CREATE TABLE Admin (
    Admin_ID INT AUTO_INCREMENT PRIMARY KEY,
    Admin_username VARCHAR(30) UNIQUE,
    Admin_pass TEXT NOT NULL
);