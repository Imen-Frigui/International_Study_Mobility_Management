# International_Study_Mobility_Management

## Description
The context of the project revolves around the management of international study mobility. This entails facilitating the dissemination of international study mobility offers,
collecting applications and their information, as well as the manual selection and nomination process. Currently, these processes are carried out manually, which can be timeconsuming, inefficient, and prone to errors. To address these challenges, the development of a platform for the management of international study mobility is proposed.

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



