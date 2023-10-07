# International Study Mobility Management

This Symfony project manages international study mobility programs, applications, and nominations.

## Prerequisites

Before you can run this project locally, make sure you have the following prerequisites installed:

- PHP 7.4 or higher
- Composer (Dependency Manager for PHP)
- Symfony CLI
- MySQL or another supported database

## Getting Started

Follow these steps to set up and run the project locally:

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Imen-Frigui/International_Study_Mobility_Management.git

2. **Navigate to the project directory:**
    ```bash
    cd International_Study_Mobility_Management

3. **Create a .env.local file in the project root and configure your database connection:**

   ```bash
    DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
   
4. **Create the database and run migrations:**
    ```bash
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate

5. **Start the Symfony development server:**
    ```bash
    symfony server:start

## Class Diagram
```mermaid
classDiagram
    class Program {
        + id: int
        + title: string
        + description: string
        + startDate: \DateTimeInterface
        + endDate: \DateTimeInterface
        + link: string
        - documents: Collection<Document>
        - programSubmissions: Collection<ProgramSubmission>
    }

    class Document {
        + id: int
        + name: string
        + path: string
        + description: string
        + status: string
        - program: Program
        - programSubmissions: Collection<ProgramSubmission>
    }

    class ProgramSubmission {
        + id: int
        - program: Program
        - documents: Collection<Document>
        - programFiles: Collection<ProgramFile>
        - student: Student
        + status: string
    }

    class ProgramFile {
        + id: int
        + name: string
        + path: string
        - programSubmission: ProgramSubmission
    }

    class Student {
        + id: int
        + name: string
        + lastName: string
        + firstYearGrade: float
        + secondYearGrade: float
        + thirdYearGrade: float
        + fourthYearGrade: float
        - programSubmissions: Collection<ProgramSubmission>
        - notifications: Collection<Notification>
        + cin: string
        + identifiant: string
    }

    class Notification {
        + id: int
        - student: Student
        + hasRead: bool
        + createdAt: \DateTimeImmutable
        + message: string
    }

    Program --* Document : documents
    Program --* ProgramSubmission : programSubmissions
    Document -- Program : program
    Document --* ProgramSubmission : programSubmissions
    ProgramSubmission -- Program : program
    ProgramSubmission --* Document : documents
    ProgramSubmission --* ProgramFile : programFiles
    ProgramSubmission -- Student : student
    Student --* ProgramSubmission : programSubmissions
    Student --* Notification : notifications
    Notification -- Student : student
```
## Genral Use Case
```mermaid
graph LR
  style Admin fill:#FF7700,stroke:#FF7700
  style Student fill:#0077FF,stroke:#0077FF

  Admin[Administrator]
  View_ProgramDescriptions[View Program Listings and Descriptions]
  Manage_Applications[Manage Application Submission and Tracking]
  Review_Evaluate[Review and Evaluate Applications]
  Communicate[Communication and Collaboration]

  Student[Student]
  View_ProgramDescriptions2[View Program Listings and Descriptions]
  Search_Programs[Search for Programs]
  Submit_Applications[Submit Applications]
  Track_Applications[Track Application Status]
  Check_Status[Check Selection and Nomination Status]
  Communicate2[Communication and Collaboration]

  Admin -->|View| View_ProgramDescriptions
  Admin -->|Manage| Manage_Applications
  Admin -->|Review, Evaluate| Review_Evaluate
  Admin -->|Communicate| Communicate

  Student -->|View, Search| View_ProgramDescriptions2
  Student -->|Submit| Submit_Applications
  Student -->|Track| Track_Applications
  Student -->|Check| Check_Status
  Student -->|Communicate| Communicate2
```



