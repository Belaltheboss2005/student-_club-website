# Student Club Website

This project is a web-based management system for university student clubs and events. It allows students and administrators to efficiently manage club memberships, organize events, and facilitate student participation.

## Purpose

The purpose of this project is to streamline the management of student clubs and events, making it easier for students to join clubs, register for events, and for administrators to oversee all related activities. It aims to foster student engagement and improve communication within the university community.

## Features

- **Student Registration & Login**:  
  Students can create accounts, log in, and manage their profiles.
  
  ![image](https://github.com/user-attachments/assets/96f2c9bb-56d9-4284-8f11-ce004bc7aef3)
  
  ![image](https://github.com/user-attachments/assets/cfbd98fd-f058-4afb-91c3-325c46289dcf)

  ![image](https://github.com/user-attachments/assets/32920e5a-da07-45ba-98f7-d197375f32a2)

  ![image](https://github.com/user-attachments/assets/8c716c80-0fa6-4d36-9fca-77a1c5470cfc)


- **Student Management**:  
  Admins can view, add, update, and delete student records, ensuring an up-to-date student database.
  
  ![image](https://github.com/user-attachments/assets/cff9b222-864e-4029-a8b6-4631e2d418fb)


- **Club Management**:  
  Admins can create, update, and delete clubs. Students can browse and join clubs.
  
  ![image](https://github.com/user-attachments/assets/26425337-33e7-45e8-9586-6534d0b755f4)

  (Students View)

  ![image](https://github.com/user-attachments/assets/553f7aaa-5284-42fe-b1c5-06a180cdbd49)


- **Event Management**:  
  Clubs can organize events, and both admins and club presidents can manage event details.

  ![image](https://github.com/user-attachments/assets/aa528e0b-e4f1-455f-a3f8-2f0704d2c59b)


- **Membership Management**:  
  Admins can manage club members and assign roles (e.g., president, member).

  ![image](https://github.com/user-attachments/assets/db49170c-4185-4f2c-8143-52070d32f683)


- **Event Participation**:  
  Students can register as attendees or organizers for events.

  ![image](https://github.com/user-attachments/assets/e09d6efa-b731-4b62-b74b-374f830b6c34)
  S
  ![image](https://github.com/user-attachments/assets/295389e8-b5d8-4ed5-8964-805f7ff62d17)

  ![image](https://github.com/user-attachments/assets/87e8d312-6200-4e89-bc55-2605411ef96b)


- **Admin Dashboard**:  
  Admins have access to dashboards for managing students, clubs, events, and club memberships.
  
  ![image](https://github.com/user-attachments/assets/093b8ae2-bc70-4d96-8df7-75fcfbb7a1c0)


## How It Works

- The **backend** uses a MySQL database (see `query.sql`) to store information about students, clubs, events, memberships, organizers, attendees, and admins.

- The **frontend** is built with **HTML**, **CSS**, and **JavaScript**, providing interfaces for students and admins.

- **PHP scripts** handle CRUD operations for all entities (students, clubs, events, etc.), with **RESTful endpoints** for frontend-backend communication.

- **Authentication** is managed for both students and admins, ensuring secure access to features based on user roles.

- All data relationships are enforced with **foreign keys** and **cascading deletes** to maintain referential integrity.
