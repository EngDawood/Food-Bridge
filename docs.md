Kingdom of Saudi Arabia
Ministry of Education
Jouf University
College of Computer and Information Sciences
THESIS
In fulfillment of the requirements for the degree of
Bachelor in Computer Since
FOODBRIDGE
SUSTAINABLE SMART APPLICATION FOR FOOD SURPLUS MANAGEMENT AND WASTE
REDUCTION
PROJECT SUPERVISOR
Supervisor NAME
Dr.Khulud Alshudukhi
GROUP MEMBERS
Noor Abdulaziz: 431205617
Hattan Nasser Alrayes :431205607
Shmokh Ali Albyali :431205150
Waad Hammad Alenzi : 431205242
2023i
PROJECT IN BRIEF
Project title:
Organization:
Objectives:
Undertaken By:
Supervised By
Date Started:
Date Completed:
Technologies
Used:
Operating System:
System Used:ii
ACKNOWLEDGEMENT
We express our respect and sharp thanks for the honor of: Our supervisor Dr.Khulud
Alshudukhi for giving us the opportunity to achieve our bachelor in Computer Engineering
Network. Her kindness, helped us in our work while trying to answer our interrogations. We
could appreciate her patience, her comprehension, her broad mindedness. She is today the
origin of this work and she is ensured of our regard and our deep gratitude.
We thank all the project committee members who have sacrificed their time in reviewing
this work, and more largely, for the interest which they carried to this project documentation.
We could like to say special thanks to all our families. Our very dear parents, nobody
can compensate for their sacrifices, that they agreed for our education and for our good
being.
We also make a point of presenting our recognitions and our thanks to any person
who helped us in all our studiesiii
DECLARATION
We hereby declare that this software, neither as a whole nor as a part has been copied
out from any source. It is further declared that we have developed this software and
accompanied report entirely on the basis of our personal efforts. If any part of this
project is proved to be copied out from any source or found to be reproduction of some
other. We will stand by the consequences. No portion of the work presented has been
submitted in support of any application for any other degree or qualification of this or
any other university or institute of learning.iv
CERTIFICATION
It is certified that the contents and form of the project
entitled .......................................................... submitted
by .........................., .................................................,
and .................................... has been found satisfactory for the requirements.
For the award of the degree of
Bachelor in Computer Since
Supervisor: (NAME AND SIGN) ............................................................
Committee Member 1: (NAME AND SIGN)................................................
Committee Member 2: (NAME AND SIGN)...............................................
Dated: ............................................v
ABSTRACT
Food waste poses a major challenge in Al-Jouf, Saudi Arabia, where surplus food is
frequently discarded despite the presence of families in need. FoodBridge is a web-based
platform developed to connect donors, beneficiaries, and volunteers to facilitate the
redistribution of surplus food. The project idea was selected based on observed community
needs and aligns with Saudi Vision 2030 goals of sustainability and social responsibility.
To ensure relevance, requirements were gathered through a structured online survey
targeting local users. The results from 73 respondents indicated high digital literacy, strong
willingness to participate in food sharing, and highlighted key challenges such as
transportation and trust.
The system was built using Laravel, MySQL, HTML5, Tailwind CSS, and JavaScript. It
supports multiple user roles and includes features such as donation matching, volunteer
coordination, and feedback mechanisms. FoodBridge offers a scalable, data-driven solution
that promotes responsible food consumption and contributes to reducing food waste in the
region.vi
CONTENTS
PROJECT IN BRIEF ................................................................................................................... i
ACKNOWLEDGEMENT ........................................................................................................ ii
DECLARATION ...................................................................................................................... iii
CERTIFICATION .................................................................................................................... iv
ABSTRACT ................................................................................................................................ v
CONTENTS .............................................................................................................................. vi
LIST OF FIGURES ................................................................................................................... ix
LIST OF TABLES ...................................................................................................................... x
ABBREVIAT ............................................................................................................................. xi
PROJECT OVERVIEW ............................................................................................................. 1
1.1 Introduction .................................................................................................................. 1
1.2 Project Scope ................................................................................................................. 2
1.3 Problem Description .................................................................................................... 2
1.4 Proposed Solution ........................................................................................................ 2
1.5 Proposed System Components .................................................................................. 3
1.6 Proposed System Output ............................................................................................ 4
1.7 Main Features of the Proposed System..................................................................... 4
1.8 Conclusion .................................................................................................................... 5
SYSTEM ANALYSIS ................................................................................................................ 7
2.1. Introduction .................................................................................................................. 7
2.2. Requirements ................................................................................................................ 7
2.3. Specification Requirements ...................................................................................... 14
2.4. Functional Requirements .......................................................................................... 14
2.5. Non-Functional Requirements ................................................................................. 15
2.6. Use Case Diagram ...................................................................................................... 15vii
2.7. General Constraints ................................................................................................... 17
2.8. Product Requirements ............................................................................................... 18
2.9. Conclusion .................................................................................................................. 18
SYSTEM DESIGN ................................................................................................................... 19
3.2. Introduction ................................................................................................................ 19
3.3. Sequence Diagram ..................................................................................................... 19
3.3.1. Donor Sequence Diagram ......................................................................... 19
3.3.2. Beneficiary Sequence Diagram................................................................. 21
3.3.3. Volunteer Sequence Diagram ................................................................... 22
3.3.4. Administrator Sequence Diagram ........................................................... 23
3.4. Activity Diagrams ...................................................................................................... 24
3.4.1. Donor and Beneficiary Activity Diagrams ............................................. 24
3.4.2. Volunteer and Administrator Activity Diagrams ................................. 25
3.5. Class Diagram............................................................................................................. 26
3.5.1. Key Classes: ................................................................................................ 27
3.5.2. Relationships:.............................................................................................. 27
3.6. Entity Relationship Diagram .................................................................................... 28
3.6.1. Key Entities and Their Roles: ................................................................... 28
3.6.2. Relationships Summary: ........................................................................... 29
3.7. Database Diagram ...................................................................................................... 29
3.7.1. Table 1: users ............................................................................................ 30
3.7.2. Table 2: donations ...................................................................................... 30
3.7.3. Table 3: requests ......................................................................................... 30
3.7.4. Table 4: delivery_tasks .............................................................................. 31
3.7.5. Table 5: feedback ........................................................................................ 31
3.7.6. Table 6: notifications .................................................................................. 31
3.7.7. Table 7: reports ........................................................................................... 32
3.8. Data Dictionary .......................................................................................................... 32
3.8.1. Table: users ................................................................................................. 32
3.8.2. Table: donations ......................................................................................... 32
3.8.3. Table: requests ............................................................................................ 33
3.8.4. Table: delivery_tasks ................................................................................. 33
3.8.5. Table: feedback ........................................................................................... 34
3.8.6. Table: notifications ..................................................................................... 34
3.8.7. Table: reports .............................................................................................. 35
4. Conclusion .................................................................................................................. 35
   IMPLEMENTATION AND TESTING................................................................................. 37
   4.1 Introduction ................................................................................................................ 37viii
   4.2 Technologies Used ..................................................................................................... 37
   4.3 System Interfaces........................................................................................................ 37
   4.4 System Coding............................................................................................................ 37
   4.5 System Testing ............................................................................................................ 37
   4.6 Deployment Diagram ................................................................................................ 37
   4.7 Conclusion .................................................................................................................. 37
   CONCLUSION & FUTURE WORK..................................................................................... 38
   5.1 Achievements ............................................................................................................. 38
   5.2 Limitations .................................................................................................................. 38
   5.3 Future Work ................................................................................................................ 38
   REFERENCES ......................................................................................................................... 39
   APPENDIX .............................................................................................................................. 40ix
   LIST OF FIGURES
   Figure 1 System Architecture – Illustrating the interaction between users, the web interface,
   backend components, and the database. .......................................................................................... 4
   Figure 3 Donor use case diagram ..................................................................................................... 16
   Figure 4 Beneficiary use case diagram ............................................................................................ 16
   Figure 5 Admin use case diagram ................................................................................................... 17
   Figure 6 Volunteer use case diagram ............................................................................................. 17
   Figure 7 : Donor Sequence Diagram ............................................................................................... 20
   Figure 8 Beneficiary Sequence Diagram ......................................................................................... 21
   Figure 9 Volunteer Sequence Diagram............................................................................................ 23
   Figure 10 Volunteer Sequence Diagram.......................................................................................... 24
   Figure 11 Donor and Beneficiary Activity Diagrams (Side-by-Side) .......................................... 25
   Figure 12 Volunteer and Administrator Activity Diagrams (Side-by-Side) .............................. 26
   Figure 13 Class Diagram Representing System Entities and Their Relationships .................... 28
   Figure 14 Entity Relationship Diagram (ERD) of the System ...................................................... 29x
   LIST OF TABLES
   Figure 1 System Architecture – Illustrating the interaction between users, the web interface,
   backend components, and the database. .......................................................................................... 4
   Figure 3 Donor use case diagram ..................................................................................................... 16
   Figure 4 Beneficiary use case diagram ............................................................................................ 16
   Figure 5 Admin use case diagram ................................................................................................... 17
   Figure 6 Volunteer use case diagram ............................................................................................. 17
   Figure 7 : Donor Sequence Diagram ............................................................................................... 20
   Figure 8 Beneficiary Sequence Diagram ......................................................................................... 21
   Figure 9 Volunteer Sequence Diagram............................................................................................ 23
   Figure 10 Volunteer Sequence Diagram.......................................................................................... 24
   Figure 11 Donor and Beneficiary Activity Diagrams (Side-by-Side) .......................................... 25
   Figure 12 Volunteer and Administrator Activity Diagrams (Side-by-Side) .............................. 26
   Figure 13 Class Diagram Representing System Entities and Their Relationships .................... 28
   Figure 14 Entity Relationship Diagram (ERD) of the System ...................................................... 29xi
   ABBREVIATCHAPTER 1. PROJECT OVERVIEW
   Page 1
   PROJECT OVERVIEW
   This chapter provides an in-depth look at the fundamental aspects of our
   proposed web application. Rooted in the Kingdom’s Vision 2030 and aligned with
   the broader global objectives of sustainable development, this system aims to
   connect individuals, restaurants, and stores to optimize the distribution of surplus
   food. The ensuing sections break down the project’s introduction, scope, problem
   description, proposed solution, system components, expected output, main
   features, and a concluding summary.
   1.1 Introduction
   Sustainable development has become a very important goal around the world,
   showing the need for new and creative ways to solve economic, social, and
   environmental problems. Saudi Arabia’s Vision 2030 gives a strong plan to
   improve different national sectors, support people’s quality of life, and encourage
   the smart use of natural resources (Saudi Vision 2030, 2024) At the same time, the
   Food and Agriculture Organization (FAO) highlights that cutting food waste helps
   reduce world hunger and also lowers harmful gas emissions caused by food
   waste(FAO: Food and Agriculture Organization of the United Nations, 2024)
   Based on these important goals, this project uses modern web technologies to
   build a platform that helps people use and share food more responsibly. Focused
   on Al-Jouf city, this project aims to create a shared system between people,
   restaurants, and shops to reduce extra food and make sure it reaches those who
   need it. By mixing the ideas of sustainability with modern technology, the project
   hopes to improve both community life and protect the environment.
   1
   ChapterCHAPTER 1. PROJECT OVERVIEW
   Page 2
   1.2 Project Scope
   The scope of this project goes from the main idea—based on community support and
   sustainability—to the technical work of building a working web platform using
   Laravel, CSS, MySQL, and a stable server. The system is made to support different
   types of users, from people sharing home-cooked meals to big food providers. With
   features like location-based matching, direct chat, and live updates, the app helps
   extra food reach the right people, including charities and families in need (United
   Nations Environment Programme, n.d.).
   Also, the scope includes adding tools for reports and data analysis to show the good
   effects of cutting food waste. These tools help measure how much carbon emissions
   go down, how often the platform is used, and give useful feedback to make the
   system better over time. The platform is built in a way that makes it easy to grow in
   the future, whether by reaching new areas in the Kingdom or connecting to more
   services.
   1.3 Problem Description
   Food waste is still a growing problem around the world. It causes serious economic,
   social, and environmental effects (World Bank Group, 2020) .In many areas, like Al-
   Jouf, large amounts of extra food are thrown away, even though there are many
   people and families who struggle with poverty. One reason for this problem is the
   absence of a clear system that connects those who have extra food with those who
   need it.
   Also, it is hard to manage the process of sharing food. Problems like transport, fast
   communication, and keeping food safe make things more difficult. Without a special
   platform to solve these issues, food waste keeps rising. This means more money is
   spent on getting rid of waste, and many helpful resources go unused. Building a
   working system to share food helps support sustainable goals and fits with Saudi
   Vision 2030 by encouraging care for others and cutting down on waste.
   1.4 Proposed Solution
   To solve the problems mentioned earlier, this project offers a full web-based solution
   that links people and groups who have extra food with those who need it. The system
   is built using Laravel (Laravel, 2025), and includes simple and helpful tools to make itCHAPTER 1. PROJECT OVERVIEW
   Page 3
   easy to sign up, offer food, and ask for it. The platform uses smart matching tools that
   work in real time, based on the food’s location, type, and how urgent the need is.
   Safety and speed are very important. The platform offers delivery choices, either
   through direct exchange between users or with the help of volunteers. Every donation
   or request is saved in the system. Data tools help show how much food was saved,
   how many people were helped, and how much waste was reduced. By mixing
   technology with community efforts, this project helps build a culture of smart food
   use and social care.
   1.5 Proposed System Components
   The proposed system consists of multiple integrated components that collaboratively
   support surplus food donation and redistribution. As illustrated in Figure 1, the
   architecture is structured into four main layers: user roles, web interface, backend
   server, and database.
   • Web Interface: A responsive front-end developed using HTML5, Tailwind CSS,
   and JavaScript, enabling users (donors, beneficiaries, and volunteers) to
   register, post donations or requests, and receive real-time notifications.
   • Users: The system accommodates three types of users—Donor, Beneficiary,
   and Volunteer—each interacting with the interface to perform role-specific
   functions, such as donation posting or delivery assistance.
   • Backend Server: Built using the Laravel framework, this layer manages:
   o Authentication & Authorization for secure access.
   o Donation & Request Management, including submission and tracking.
   o A Matching Algorithm that pairs donations with relevant requests
   based on predefined criteria (e.g., location, urgency).
   o Delivery Coordination that facilitates volunteer-driven or direct user
   delivery.
   o Analytics & Reporting to support operational insight and transparency.
   • Database: A MySQL database stores structured data related to users,
   transactions, and analytics, ensuring data integrity and availability.
   This system design promotes efficient food redistribution and aligns with the
   principles of sustainable development and Saudi Vision 2030 by minimizing food
   waste and enhancing community collaboration.CHAPTER 1. PROJECT OVERVIEW
   Page 4
   Figure 1 System Architecture – Illustrating the interaction between users, the web interface,
   backend components, and the database.
   1.6 Proposed System Output
   The primary outputs of this system encompass the facilitation of food transactions,
   comprehensive analytics, and user feedback mechanisms. Users can view real-time
   dashboards reflecting ongoing donations, requests, and completed transactions,
   offering them a transparent overview of the project’s impact . Additionally, periodic
   reports quantify the reduction in food waste—particularly the decrease in carbon
   emissions and landfill usage—offering evidence-based data to drive future
   improvements.
   By underscoring user satisfaction, the platform also collects and analyzes feedback to
   refine user experience, suggesting enhancements to the matching algorithm and
   optimizing delivery scheduling. Over time, these output metrics will play a vital role
   in expanding the project to other cities and establishing partnerships with local
   charities, non-governmental organizations (NGOs), and food providers.
   1.7 Main Features of the Proposed System
   The following primary features will be implemented in the proposed system to
   directly address the core issue of surplus food redistribution in Al-Jouf:
   • User Registration and Profiles: Users (donors, beneficiaries, volunteers) can
   register easily and create detailed profiles specifying their roles, locations, and
   preferences.CHAPTER 1. PROJECT OVERVIEW
   Page 5
   • Food Donation Posting: Donors can post surplus food items clearly indicating
   type, quantity, expiration dates, and pickup conditions.
   • Beneficiary Requests: Beneficiaries can create detailed food requests
   specifying their requirements, including food types, quantities, and urgency.
   • Real-Time Matching: Automatic matching of available food donations with
   beneficiary requests based on proximity, urgency, food type, and availability.
   • Instant Notifications: Users receive immediate alerts regarding matched
   donations, available requests, and volunteer opportunities to expedite timely
   redistribution.
   • Delivery Management: Integrated coordination tools facilitate direct
   exchanges between donors and beneficiaries, as well as volunteer-driven
   delivery operations.
   • Quality and Safety Verification: The system includes an optional verification
   step where donors can provide information regarding food quality, storage
   conditions, and adherence to safety standards.
   • Volunteer Coordination and Scheduling: Volunteers can sign up for specific
   delivery slots, track their assigned tasks, and receive real-time updates on pick-
   up and drop-off locations.
   • Rating and Feedback System: A mechanism for users to provide feedback on
   donations, deliveries, and overall experience to ensure continuous
   improvement and trust among participants.
   • Community Engagement and Awareness: The platform will feature
   educational content, sustainability tips, and impact stories to encourage
   responsible food consumption and waste reduction.
   • Analytics Dashboard: An interactive dashboard offering clear metrics about
   redistributed food quantities, transaction statuses, and community impact,
   supporting informed decisions and future planning.
   These practical functionalities collectively enable the efficient management and
   effective redistribution of surplus food, directly addressing food waste challenges and
   enhancing community welfare.
   1.8 Conclusion
   In this first chapter, we have outlined the conceptual framework and objectives of a
   web-based application dedicated to minimizing food waste in Al-Jouf city. By
   highlighting the problem scope, proposed solution, system components, expected
   outcomes, and main features, we underscore how this initiative aligns with both
   Vision 2030 and global sustainability agendas. By harnessing modern technologiesCHAPTER 1. PROJECT OVERVIEW
   Page 6
   such as Laravel, CSS, and MySQL, the system aspires to streamline the distribution of
   surplus food, reduce environmental footprints, and promote a culture of social
   responsibility. The subsequent chapters will delve into the technical design,
   implementation strategies, and validation approaches that further shape this project’s
   success.CHAPTER 2. SYSTEM ANALYSIS
   Page 7
   SYSTEM ANALYSIS
   2.1. Introduction
   This chapter provides a detailed analysis of the proposed system, defining essential
   requirements and clarifying user expectations. It discusses the methodology used in
   gathering and analyzing these requirements to ensure the system meets the specific
   needs and expectations of donors, beneficiaries, and volunteers within the Al-Jouf
   community.
   2.2. Requirements
   In order to ensure the successful implementation of the FoodBridge system, a
   thorough understanding of user and system requirements was obtained. The
   primary method used for requirements gathering was an online survey designed to
   explore the behaviors, challenges, and expectations of potential users in Al-Jouf,
   including donors, beneficiaries, and volunteers.
   The survey received responses from 73 participants, and the collected data provided
   rich insights into community needs and digital readiness. The survey results are
   presented and analyzed in the following figures, each containing two charts that
   correspond to two related questions.
   2.2.1. Respondents’ Gender and Age Distribution
   Figure 2 – Distribution of respondents by gender (left) and age group (right).
   A significant majority of participants were female (87.7%), reflecting the
   central role women may play in food donation and redistribution efforts. The
   age data shows that 48.6% of respondents are between 18–30 years, followed
   by 34.7% aged 31–50. This indicates that the target audience is digitally
   literate and socially active, supporting the development of a web-based
   solution that is intuitive and engaging for a younger demographic.
   2
   ChapterCHAPTER 2. SYSTEM ANALYSIS
   Page 8
   Figure 2 Distribution of respondents by gender (up) and age group (down).
   2.2.2. Residency and Daily Internet Usage
   Figure 3 – Percentage of respondents residing in Al-Jouf (left) and those who use the
   internet daily (right).
   An overwhelming 97.3% of respondents reported that they reside in Al-Jouf,
   which confirms the geographical validity of focusing the system's
   deployment in this region. Furthermore, 98.6% of respondents use the
   internet daily, strongly indicating that a web-based platform is technically
   viable and well-suited for the target population.
   Figure 3 Percentage of respondents residing in Al-Jouf (top) and those whoCHAPTER 2. SYSTEM ANALYSIS
   Page 9
   use the internet daily (down).
   2.2.3. Digital Literacy and Food Waste Behavior
   Figure 4 – Participants’ experience with digital platforms (left) and whether they have
   discarded surplus food in the past (right).
   Nearly all participants (95.9%) are familiar with apps and websites, reducing
   potential barriers to adopting the system. Moreover, 84.9% acknowledged
   having previously discarded surplus food, revealing a critical gap in food
   utilization and confirming the societal need for a structured redistribution
   mechanism like FoodBridge.
   Figure 4 Participants’ experience with digital platforms (left)
   and whether they have discarded surplus food in the past (right).
   2.2.4. Interest in Redistribution and Type of Donatable Food
   Figure 5 – Willingness to redistribute surplus food (left) and type of food available for
   donation (right).
   A very high percentage (93.1%) expressed interest in participating in food
   redistribution. Regarding donation type, 58.9% are willing to donate home-
   cooked meals, while 41.1% would donate commercial food. These responses
   emphasize the importance of including food safety guidelines and
   classification features in the system.CHAPTER 2. SYSTEM ANALYSIS
   Page 10
   Figure 5 Willingness to redistribute surplus food (left) and type
   of food available for donation (right).
   2.2.5. Preferred Donation Method and Donation Barriers
   Figure 6 – Preferred donation method (left) and reasons preventing food donation
   (right).
   Participants were nearly evenly split between preferring online donation
   (45.8%) and direct communication (54.2%), suggesting that the platform
   should accommodate both styles of engagement. The most cited barrier was
   the responsibility of delivering food (74%), which supports the need for a
   volunteer-based delivery feature within the platform.
   Figure 6 Preferred donation method (left) and reasons
   preventing food donation (right).CHAPTER 2. SYSTEM ANALYSIS
   Page 11
   2.2.6. Food Security Challenges and Willingness to Use the Platform
   Figure 7 – Difficulty securing food (left) and willingness to use a digital platform for
   receiving donations (right).
   Although 47.9% reported no difficulty accessing food, 23.3% said they face
   food insecurity, with another 28.8% saying “sometimes.” This validates the
   necessity of the platform. Furthermore, 76.7% indicated they would use such
   a system, confirming strong community acceptance.
   Figure 7 Difficulty securing food (left) and willingness to use a digital
   platform for receiving donations (right).
   2.2.7. Type of Needed Food and Challenges for Beneficiaries
   Figure 8 – Most needed food types (left) and anticipated challenges in receiving food
   (right).
   More than half the respondents (54.9%) need cooked food, followed by 33.8%
   seeking fresh food. Challenges faced include lack of transportation (56.3%)
   and mistrust in food source (38%). These findings justify the inclusion of
   donor verification, food classification, and delivery assistance in the
   platform design.CHAPTER 2. SYSTEM ANALYSIS
   Page 12
   Figure 8 Most needed food types (left) and anticipated challenges
   in receiving food (right).
   2.2.8. Willingness to Volunteer and Frequency of Availability
   Figure 9 – Readiness to participate in food delivery (left) and frequency of volunteer
   availability (right).
   The community shows strong engagement, with 79.5% willing to volunteer
   for food delivery. Most volunteers are available once or twice per week,
   which supports the system’s ability to match deliveries with volunteer
   capacity and promote operational sustainability.
   Figure 9 Readiness to participate in food delivery (left) and
   frequency of volunteer availability (right).CHAPTER 2. SYSTEM ANALYSIS
   Page 13
   2.2.9. Transportation Methods and Motivations to Volunteer
   Figure 10 – Available transportation methods (left) and motivations for volunteering
   (right).
   Most volunteers (94.4%) have access to a private car, which resolves a major
   logistical concern. Additionally, 84.7% of respondents reported being
   motivated by religious values, followed by social and personal reasons. These
   insights could be leveraged in the platform’s design by featuring community
   impact stories and recognition tools.
   Figure 10 Available transportation methods (left) and motivations
   for volunteering (right).
   The survey results clearly highlighted a real need within the Al-Jouf community for a
   system that addresses food waste and improves surplus food redistribution. A large
   percentage of respondents reported having discarded food before and showed
   strong interest in a platform that facilitates donations. Additionally, the majority
   demonstrated high digital literacy and daily internet usage, confirming the
   suitability of a web-based solution. Key challenges such as transportation and
   delivery responsibility were also identified, which the system addresses throughCHAPTER 2. SYSTEM ANALYSIS
   Page 14
   volunteer coordination features. These findings provide concrete justification for
   developing FoodBridge, ensuring that the platform is based on actual community
   needs and is capable of delivering measurable social impact.
   2.3. Specification Requirements
   The specification requirements establish detailed hardware and software conditions
   necessary for successful system deployment:
   2.1.1. Hardware Requirements:
   • Reliable web server capable of handling Laravel applications
   • Server specifications: minimum of 8 GB RAM, SSD storage, and sufficient
   CPU capacity for expected user loads
   • Stable internet connectivity for real-time system performance
   2.1.2. Software Requirements:
   • Web Framework: Laravel (latest stable version)
   • Server Operating System: Windows
   • Database Management System: MySQL version 8.2
   • Front-end Development: HTML5, Tailwind CSS, JavaScript
   • Browser compatibility: Chrome, Firefox, Safari, Edge
   2.4. Functional Requirements
   2.1.3. Common Functionalities for All Users:
   • View homepage content, including general information and latest donations.
   • User registration, authentication, and secure login/logout.
   • Profile creation and management (edit personal and contact information).
   • Real-time notifications for system updates, matches, and messages.
   • Transaction completion confirmation and feedback submission (ratings and
   comments).
   2.1.4. Donor-Specific Functionalities:
   • Post surplus food donations with detailed information (food type, quantity,
   expiration, availability).
   • Manage existing food donation postings (update, delete, mark as completed).
   • View matched beneficiary requests and associated details.
   2.1.5. Beneficiary-Specific Functionalities:
   • Submit detailed requests for surplus food (food types, quantities, urgency).
   • Manage existing food requests (edit, delete, update urgency).
   • View matched donations and confirm acceptance.CHAPTER 2. SYSTEM ANALYSIS
   Page 15
   2.1.6. Volunteer-Specific Functionalities:
   • View available delivery tasks and associated details (pickup/drop-off
   locations).
   • Select, track, and manage delivery tasks through completion.
   • Update task status (picked up, delivered, confirmed).
   2.1.7. Administrator-Specific Functionalities:
   • Manage user accounts and oversee platform security.
   • Monitor platform transactions, donations, requests, and deliveries.
   • Access system analytics and generate comprehensive reports.
   2.5. Non-Functional Requirements
   • Usability: Intuitive, user-friendly interfaces with accessible navigation.
   • Performance: High responsiveness, scalability, and consistent real-time
   updates.
   • Reliability: System stability, robust backup strategies, fault tolerance.
   • Security: Strong user data protection, secure authentication mechanisms.
   • Maintainability: Easy maintenance, scalable architecture, and
   straightforward updates.
   2.6. Use Case Diagram
   • Actors: Donors, Beneficiaries, Volunteers, and Administrators
   • Main interactions include account management, donation/request posting,
   matching, notifications, delivery management, feedback submission, and
   reporting.CHAPTER 2. SYSTEM ANALYSIS
   Page 16Donor
   LoginRegister
   Manage Profile
   Post Food Donation
   Manage Donations
   Validate
   <<include>>
   Load User Data
   <<include>>
   Forgot Password
   <<Extend>>
   <<include>>
   Send Verification Code
   <<include>>
   Verify Account
   <<Extend>>
   Update Account Details
   <<include>>
   Change Password
   <<Extend>>
   Add Location Data
   <<Extend>>
   Upload Food Image
   Enter Donation Details
   Schedule Donation
   <<include>>
   <<include>>
   <<Extend>>
   Receive Real-Time Notifications
   Logout
   Transaction Confirmation
   Send Feedback
   <<include>> Confirm Delivery
   Enter Feedback
   Add Comment
   <<include>>
   <<Extend>>
   Add Delete
   Edite
   <<Extend>> <<Extend>>
   <<Extend>>
   Figure 11 Donor use case diagramSubmit Food Request
   Manage Food Requests
   Beneficiary Receive Real-Time Notifications
   Transaction Confirmation
   Send Feedback
   Logout
   Enter Request Details
   <<Extend>>
   Attach Special Notes
   <<Extend>>
   LoginRegister
   Manage Profile
   Validate
   <<include>>
   Load User Data
   <<include>>
   Forgot Password
   <<Extend>>
   <<include>>
   Send Verification Code
   <<include>>
   Verify
   Account
   <<Extend>> Update Account Details
   <<include>>
   Change Password
   <<Extend>>
   Add Location Data
   <<Extend>>
   Figure 12 Beneficiary use case diagramCHAPTER 2. SYSTEM ANALYSIS
   Page 17Admin
   Manage User Accounts
   Monitor Transactions and Reports
   Logout
   View User List
   Add user
   Delete User
   <<Extend>>
   <<Extend>>
   <<Extend>>
   Register
   Manage Profile
   Validate
   <<include>>
   Send Verification Code
   <<include>>
   Verify Account <<Extend>>
   Update Account Details
   <<include>>
   Change Password
   <<Extend>>
   Add Location Data
   <<Extend>>
   Figure 13 Admin use case diagram
   Figure 14 Volunteer use case diagram
   2.7. General Constraints
   • Technological constraints: Internet stability, server capabilities.CHAPTER 2. SYSTEM ANALYSIS
   Page 18
   • Regulatory constraints: Compliance with local food safety standards and data
   privacy laws.
   • User engagement constraints: Dependence on community awareness and user
   technological literacy.
   2.8. Product Requirements
   • Reliable web hosting service with high availability.
   • Cross-platform compatibility (mobile and desktop browsers).
   • Stable internet infrastructure supporting real-time data exchange.
   2.9. Conclusion
   This chapter systematically outlined the process of requirements gathering and
   detailed analysis of functional, non-functional, software, and hardware requirements.
   It highlighted essential constraints and clearly defined the interactions and
   responsibilities of each user type, thus laying a solid foundation for effective system
   implementation and operation.CHAPTER 3. SYSTEM DESIGN
   Page 19
   SYSTEM DESIGN
   3.2. Introduction
   This chapter provides a comprehensive overview of the system architecture and
   internal design of the proposed web-based platform for food surplus redistribution.
   The system is structured to support multiple user roles—namely donors, beneficiaries,
   volunteers, and administrators—while ensuring secure and efficient operations for
   every actor. The design is based on the principles of modularity, scalability, and
   maintainability, ensuring long-term adaptability to the goals of Saudi Vision 2030 and
   broader sustainability frameworks.
   The design components in this chapter include multiple modeling diagrams to
   illustrate the static and dynamic behavior of the system. These include sequence
   diagrams for interaction flow, activity diagrams for process modeling, class diagrams
   for structural design, entity relationship diagrams for logical data structure, database
   schemas for physical implementation, and a detailed data dictionary to define all data
   elements.
   3.3. Sequence Diagram
   Sequence diagrams represent the dynamic interaction between different system
   components and actors over time. They illustrate how messages are exchanged and
   how each actor or component responds during specific operations. Four sequence
   diagrams have been developed to cover the core user roles in the system:
   3.3.1. Donor Sequence Diagram
   This diagram outlines the donor’s interaction flow, including updating profile
   information, posting a food donation, confirming delivery, and submitting feedback.
   Optional paths such as donation scheduling and adding a comment after feedback
   are also considered
   3
   ChapterCHAPTER 3. SYSTEM DESIGN
   Page 20
   Figure 3.1: Donor Sequence Diagram
   This diagram illustrates the complete interaction process between a donor and the system,
   including optional steps such as scheduling and feedback commentary.
   Figure 15 : Donor Sequence DiagramCHAPTER 3. SYSTEM DESIGN
   Page 21
   3.3.2. Beneficiary Sequence Diagram
   This diagram captures how a beneficiary submits a food request, tracks the request
   status, confirms receipt upon delivery, and leaves feedback. Optional steps include
   attaching notes or adding comments after the rating process.
   Figure 3.2: Beneficiary Sequence Diagram
   This diagram shows the core activities performed by beneficiaries, including the interaction
   flow related to matching donations and confirming delivery.
   Figure 16 Beneficiary Sequence DiagramCHAPTER 3. SYSTEM DESIGN
   Page 22
   3.3.3. Volunteer Sequence Diagram
   This diagram describes the volunteer’s journey in the system, from viewing and
   accepting delivery tasks to tracking and completing them. It also includes feedback
   submission and optional commentary.
   Figure 3.3: Volunteer Sequence Diagram
   The diagram represents how volunteers engage in the delivery process and contribute to the
   distribution workflow.CHAPTER 3. SYSTEM DESIGN
   Page 23
   Figure 17 Volunteer Sequence Diagram
   3.3.4. Administrator Sequence Diagram
   This diagram explains the administrator’s interaction with the system, including
   profile management, user monitoring, and report generation. Admins are responsible
   for overseeing the platform’s functionality and maintaining data integrity.
   Figure 3.4: Administrator Sequence Diagram
   The diagram captures the administrator’s high-level responsibilities and actions within the
   system.CHAPTER 3. SYSTEM DESIGN
   Page 24
   Figure 18 Volunteer Sequence Diagram
   3.4. Activity Diagrams
   Activity diagrams are used to model the internal workflows and business processes
   within the system. These diagrams illustrate the sequence of activities performed by
   different actors, including decision points and optional flows. They help in
   understanding how operations are structured, how users interact with the system,
   and how the system handles parallel or conditional tasks.
   In this project, a unified activity diagram is used to present the core workflow of all
   four user roles—donor, beneficiary, volunteer, and administrator—in a single
   integrated flow. This consolidated model emphasizes the interactions and
   dependencies between user actions, ensuring a clear overview of how the system
   supports cooperation between stakeholders.
   3.4.1. Donor and Beneficiary Activity Diagrams
   The first two activity diagrams illustrate the actions performed by donors and
   beneficiaries. Donors are responsible for posting food donations, optionallyCHAPTER 3. SYSTEM DESIGN
   Page 25
   scheduling pickups, confirming delivery, and submitting feedback. Beneficiaries
   submit requests, view available donations, confirm receipt, and also provide feedback.
   Figure 3.5: Donor and Beneficiary Activity Diagrams (Side-by-Side)
   These diagrams display the typical workflows of donors and beneficiaries. Optional branches
   like scheduling a pickup or adding a comment during feedback are shown to capture the full
   range of possible actions.
   Figure 19 Donor and Beneficiary Activity Diagrams (Side-by-Side)
   3.4.2. Volunteer and Administrator Activity Diagrams
   The second group of diagrams illustrates the actions of volunteers and administrators.
   Volunteers engage in selecting, performing, and completing delivery tasks, while
   administrators are responsible for user management, system monitoring, and report
   generation. Both diagrams reflect essential operational flows that ensure system
   effectiveness and governance.CHAPTER 3. SYSTEM DESIGN
   Page 26
   Figure 3.6: Volunteer and Administrator Activity Diagrams (Side-by-Side)
   These diagrams highlight the support and management roles in the system. Volunteers ensure
   the execution of food deliveries, while administrators handle platform oversight and
   administrative control.
   Figure 20 Volunteer and Administrator Activity Diagrams (Side-by-Side)
   3.5. Class Diagram
   The class diagram provides a structural blueprint of the system by modeling its core
   classes, attributes, and the relationships between them. It is an essential part of object-
   oriented analysis and design, illustrating how data and behavior are organized within
   the system.
   This diagram plays a critical role in the implementation of the web application, as it
   directly informs the backend logic and database structure. Each class represents aCHAPTER 3. SYSTEM DESIGN
   Page 27
   real-world entity or functional component in the system, such as users, donations,
   requests, deliveries, feedback, and administrative reports.
   3.5.1. Key Classes:
   • User: A generic class representing all system users (donors, beneficiaries,
   volunteers, and administrators). Includes core attributes and profile
   management methods.
   • Donation: Represents food donations created by donors, including
   attributes such as food type, quantity, and pickup time.
   • Request: Created by beneficiaries to request food; may be linked to a
   matching donation.
   • DeliveryTask: Assigned to volunteers, tracking the delivery process from
   donor to beneficiary.
   • Feedback: Allows users to rate and comment on other users after a
   transaction.
   • Notification: Represents system-generated messages to inform users of
   updates or matches.
   • Admin: Includes administrative operations like user management and
   report generation.
   • Report: Generated by administrators to summarize platform activity and
   impact.
   3.5.2. Relationships:
   • A user can create multiple donations, requests, feedbacks, and delivery tasks.
   • A donation can be matched to one or more requests and assigned to a delivery
   task.
   • Each feedback entry is linked to two users: sender and recipient.
   • Admins are associated with reports they generate.
   Figure 3.6: Class Diagram Representing System Entities and Their Relationships
   This diagram illustrates the object-oriented structure of the application. It defines each class,
   its attributes, and the connections between classes, supporting maintainable and scalable
   software architecture.CHAPTER 3. SYSTEM DESIGN
   Page 28
   Figure 21 Class Diagram Representing System Entities and Their Relationships
   3.6. Entity Relationship Diagram
   The Entity Relationship Diagram (ERD) provides a high-level conceptual model of the
   database by defining entities (tables), their attributes, and the relationships between
   them. This model is essential in the database design process, ensuring that data is
   organized efficiently and that integrity is maintained across the system.
   Unlike the class diagram—which is object-oriented and focuses on system behavior—
   the ERD emphasizes data storage and how entities relate to one another. It serves as a
   blueprint for designing the logical schema of the database and facilitates clear
   communication among designers, developers, and database administrators.
   3.6.1. Key Entities and Their Roles:
   • Users: Central table that holds information for all system users (donors,
   beneficiaries, volunteers, admins).
   • Donations: Stores data related to food donations posted by donors.
   • Requests: Records food requests created by beneficiaries, with optional
   linkage to a donation.
   • DeliveryTasks: Represents delivery assignments handled by volunteers.
   • Feedback: Contains user ratings and comments given after completed
   transactions.
   • Notifications: Logs system-generated messages directed to users.
   • Reports: Admin-generated records for system monitoring and analytics.CHAPTER 3. SYSTEM DESIGN
   Page 29
   3.6.2. Relationships Summary:
   • A User can have many Donations, Requests, Feedback, DeliveryTasks, and
   Notifications.
   • A Donation can be associated with multiple Requests and a DeliveryTask.
   • A Request may be optionally linked to a Donation.
   • A Feedback entry connects two users: the reviewer and the recipient.
   • An Admin (User) can generate multiple Reports.
   Figure 3.7: Entity Relationship Diagram (ERD) of the System
   This diagram shows the logical relationships between the main entities in the platform. It
   serves as a foundation for designing the normalized structure of the underlying database and
   ensuring data integrity.
   Figure 22 Entity Relationship Diagram (ERD) of the System
   3.7. Database Diagram
   The Database Diagram represents the physical structure of the database, focusing on
   the actual tables, columns, data types, and key constraints such as primary and
   foreign keys. Unlike the ERD, which models logical relationships, the database
   diagram is implementable directly in relational database systems like MySQL.
   This section presents each table individually in a tabular format, showing its schema,
   including all fields, data types, and constraints. Each table is accompanied by a figure
   reference and a caption that clearly identifies its purpose within the system.CHAPTER 3. SYSTEM DESIGN
   Page 30
   3.7.1. Table 1: users
   Column
   Name
   Data Type Key
   Type
   Description
   id INT PK Unique identifier for the user
   name VARCHAR(100) Full name
   email VARCHAR(100) UNIQUE Email address
   password VARCHAR(255) Encrypted login password
   role ENUM User type: donor, beneficiary,
   volunteer, admin
   location VARCHAR(255) User's physical location
   Table 3.7:1 Table definition for users — contains user credentials and role classification
   3.7.2. Table 2: donations
   Column Name Data Type Key Type Description
   id INT PK Unique donation ID
   donor_id INT FK Foreign key referencing users(id)
   food_type VARCHAR(100) Type of donated food
   quantity INT Quantity of food donated
   expiration_date DATE Expiry date of the food
   pickup_time DATETIME Scheduled pickup time
   status ENUM Status: pending, scheduled, delivered
   Table 3.7:2 Table definition for donations — stores all donation records posted by donors .
   3.7.3. Table 3: requests
   Column
   Name
   Data Type Key
   Type
   Description
   id INT PK Unique request ID
   beneficiary_id INT FK Foreign key referencing users(id)
   food_type VARCHAR(100) Type of food requested
   quantity INT Quantity requested
   note TEXT Optional note added by the
   beneficiary
   donation_id INT FK (Nullable) Foreign key to
   donations(id)CHAPTER 3. SYSTEM DESIGN
   Page 31
   status ENUM Status: pending, matched, fulfilled
   Table 3.7:3 Table definition for requests — logs all food requests made by beneficiaries.
   3.7.4. Table 4: delivery_tasks
   Column Name Data Type Key
   Type
   Description
   id INT PK Unique delivery task ID
   volunteer_id INT FK Foreign key referencing users(id)
   donation_id INT FK Foreign key referencing
   donations(id)
   pickup_location VARCHAR(255) Location to pick up the donation
   dropoff_location VARCHAR(255) Final destination of the delivery
   status ENUM assigned, in_progress, completed
   Table 3.7:4 Table definition for delivery tasks — tracks deliveries handled by volunteers.
   3.7.5. Table 5: feedback
   Column Name Data Type Key Type Description
   id INT PK Unique feedback ID
   from_user_id INT FK User who provides the feedback
   to_user_id INT FK User receiving the feedback
   rating INT Rating score (e.g., 1 to 5)
   comment TEXT Optional comment
   Table 3.7:5 Table definition for feedback — contains post-transaction user evaluations.
   3.7.6. Table 6: notifications
   Column Name Data Type Key Type Description
   id INT PK Unique notification ID
   user_id INT FK Targeted user ID
   message VARCHAR(255) Notification text
   type ENUM Type: match, update, alert
   is_read BOOLEAN Indicates if the message was read
   Table 3.7:6 Table definition for notifications — stores system-triggered messages to users.CHAPTER 3. SYSTEM DESIGN
   Page 32
   3.7.7. Table 7: reports
   Column Name Data Type Key Type Description
   id INT PK Unique report ID
   admin_id INT FK Foreign key referencing users(id)
   title VARCHAR(255) Title of the report
   content TEXT Detailed content of the report
   created_at DATETIME Date and time the report was created
   Table 3.7:7 Table definition for reports — includes platform reports generated by admins.
   3.8. Data Dictionary
   The data dictionary provides a detailed reference for all the data elements used in the
   system. It defines each field in the database, its type, constraints, and its role within
   the application logic. This documentation is essential for ensuring consistency and
   accuracy during development, testing, and maintenance of the system.
   3.8.1. Table: users
   Field
   Name
   Data Type Null
   Allowed
   Key
   Type
   Description
   id INT No PK Unique identifier for each
   user
   name VARCHAR(100) No Full name of the user
   email VARCHAR(100) No UNIQUE Email address used for login
   and communication
   password VARCHAR(255) No Encrypted password
   role ENUM No User role: donor, beneficiary,
   volunteer, admin
   location VARCHAR(255) Yes User's address or service
   region
   Table 3.8:1 Data Dictionary for users table.
   3.8.2. Table: donations
   Field Name Data Type Null
   Allowed
   Key
   Type
   Description
   id INT No PK Unique ID for each
   donationCHAPTER 3. SYSTEM DESIGN
   Page 33
   donor_id INT No FK References the user who
   made the donation
   food_type VARCHAR(100) No Type of food item being
   donated
   quantity INT No Quantity available
   expiration_date DATE Yes Expiry date of the donated
   item (if applicable)
   pickup_time DATETIME Yes Scheduled time for pickup
   status ENUM No Donation status: pending,
   scheduled, delivered
   Table 3.8:2 Data Dictionary for donations table.
   3.8.3. Table: requests
   Field Name Data Type Null
   Allowed
   Key
   Type
   Description
   id INT No PK Unique ID for each request
   beneficiary_id INT No FK References the requesting
   user
   food_type VARCHAR(100) No Type of food requested
   quantity INT No Amount of food needed
   note TEXT Yes Optional note from
   beneficiary
   donation_id INT Yes FK Optional match to a
   donation
   status ENUM No Request status: pending,
   matched, fulfilled
   Table 3.8:3 Data Dictionary for requests table.
   3.8.4. Table: delivery_tasks
   Field Name Data Type Null
   Allowed
   Key
   Type
   Description
   id INT No PK Unique ID for each
   delivery task
   volunteer_id INT No FK References the volunteer
   assignedCHAPTER 3. SYSTEM DESIGN
   Page 34
   donation_id INT No FK References the related
   donation
   pickup_location VARCHAR(255) No Location where the food
   is picked up
   dropoff_location VARCHAR(255) No Final delivery destination
   status ENUM No Task status: assigned,
   in_progress, completed
   Table 3.8:4 Data Dictionary for delivery_tasks table.
   3.8.5. Table: feedback
   Field Name Data
   Type
   Null
   Allowed
   Key
   Type
   Description
   id INT No PK Unique feedback entry
   from_user_id INT No FK ID of the user providing
   feedback
   to_user_id INT No FK ID of the user receiving the
   feedback
   rating INT No Rating score between 1 and 5
   comment TEXT Yes Optional feedback comment
   Table 3.8:5 Data Dictionary for feedback table.
   3.8.6. Table: notifications
   Field
   Name
   Data Type Null
   Allowed
   Key
   Type
   Description
   id INT No PK Unique ID for the notification
   user_id INT No FK ID of the user receiving the
   notification
   message VARCHAR(255) No Notification message content
   type ENUM No Type of notification: match,
   alert, etc.
   is_read BOOLEAN No Read status (true/false)
   Table 3.8:6 Data Dictionary for notifications table.CHAPTER 3. SYSTEM DESIGN
   Page 35
   3.8.7. Table: reports
   Field
   Name
   Data Type Null
   Allowed
   Key
   Type
   Description
   id INT No PK Unique ID for the report
   admin_id INT No FK ID of the admin who
   generated report
   title VARCHAR(255) No Title of the report
   content TEXT No Full content of the report
   created_at DATETIME No Timestamp when report was
   generated
   Table 3.8:7 Data Dictionary for reports table.
4. Conclusion
   This chapter presented the complete design blueprint of the proposed web-based food
   redistribution system. Through a structured combination of behavioral and structural diagrams,
   the system architecture was fully mapped to reflect real-world operations involving multiple
   user roles: donors, beneficiaries, volunteers, and administrators.
   Sequence diagrams illustrated the time-based interactions between actors and system
   components, while activity diagrams captured the internal workflows across users. The class
   diagram provided a modular view of object-oriented relationships, ensuring maintainability
   and scalability. Additionally, the entity relationship diagram (ERD) and physical database
   diagram translated the logical structure into a fully normalized database schema. Finally, the
   data dictionary offered a detailed specification of each data element, supporting clear
   development guidelines and facilitating system maintenance.
   This comprehensive design serves as a foundation for implementation and future scalability.
   The next chapters will delve into system implementation details and performance evaluation to
   validate the effectiveness of the proposed solution.CHAPTER 3. SYSTEM DESIGN
   Page 36
   FUTURE WORK
   While the proposed FoodBridge platform establishes a comprehensive system for
   surplus food redistribution in Al-Jouf city, future enhancements and expansions are
   critical to sustaining its impact and ensuring its scalability to broader regions. This
   chapter outlines potential improvements, advanced functionalities, and research
   directions that could be pursued to optimize the system’s effectiveness, resilience, and
   community engagement.
   System Expansion Opportunities
   One of the primary future goals is to extend FoodBridge’s deployment beyond Al-
   Jouf to other cities across Saudi Arabia. To achieve this, regional customization
   features could be incorporated, such as localized food regulations, transportation
   logistics, and community-specific outreach strategies. Furthermore, partnerships
   with national charitable organizations and municipal governments would enhance
   the platform’s reach and effectiveness.
   Mobile Application Development
   To increase accessibility and engagement, a dedicated mobile application for
   Android and iOS devices is recommended. A mobile version would offer features
   such as push notifications, GPS tracking for deliveries, and instant communication
   between donors, beneficiaries, and volunteers, thereby improving the overall user
   experience.
   Integration with Food Suppliers and Supermarkets
   Future work should also include forging partnerships with supermarkets,
   restaurants, and food suppliers. Implementing an API system would allow
   businesses to automatically post surplus food listings directly from their inventory
   management systems, streamlining the donation process and increasing the
   volume of available food.CHAPTER 4. IMPLEMENTATION AND TESTING
   Page 37
   IMPLEMENTATION AND
   TESTING
   4.1 Introduction
   ..............................................
   4.2 Technologies Used
   .............................................
   4.3 System Interfaces
   ....................................................
   4.4 System Coding
   ................
   4.5 System Testing
   ...............
   4.6 Deployment Diagram
   ..........................................
   4.7 Conclusion
   ..............................................
   4
   ChapterCHAPTER 5. CONCLUSION & FUTURE WORK
   Page 38
   CONCLUSION & FUTURE WORK
   5.1 Achievements
   ...................................
   5.2 Limitations
   .............................................
   5.3 Future Work
   .......................................
   5
   ChapterPage 39
   REFERENCES
1. FAO: Food and Agriculture Organization of the United Nations. (2024). Putting
   a spotlight on our food's hidden costs. Retrieved from Food and Agriculture
   Organization of the United Nations: https://www.fao.org/
2. Laravel. (2025). Official Documentation. Retrieved from Laravel:
   https://laravel.com/docs/11.x
3. Saudi Vision 2030. (2024). Vision 2030 Kingdom of Saudi Arabia. Retrieved from
   https://www.vision2030.gov.sa/
4. Tailwindcss. (2025). Get started with Tailwind CSS. Retrieved from
   https://tailwindcss.com/docs/installation/using-vite
5. United Nations Environment Programme. (n.d.). UNEP Food Waste Index Report
2021. Retrieved from https://www.unep.org/
6. World Bank Group. (2020). A New Food Economy, Rooted in Progress. Retrieved
   from World Bank Group: https://www.worldbank.org/ext/en/homePage 40
   APPENDIX


:
FoodBridge
SUSTAINABLE SMART APPLICATION FOR FOOD
SURPLUS MANAGEMENT AND WASTE REDUCTION
PROJECT SUPERVISOR Supervisor NAME
Dr.Khulud Alshudukhi
GROUP MEMBERS
Noor Abdulaziz :431205617
Hattan Nasser Alrayes :431205607
Shmokh Ali Albyali :431205150
Waad Hammad Alenzi : 431205242Introduction
Sustainable development is a global priority addressing
economic, social, and environmental challenges.
Saudi Vision 2030 provides a transformative framework for
promoting social well-being and resource efficiency.
FoodBridge leverages modern web technologies to promote
responsible food consumption and redistribution.
The project aims to reduce food waste in Al-Jouf by connecting
individuals, restaurants, and stores with beneficiaries.
01
02
03
04Scope project
Accommodates various user types: individual
donors, large-scale providers, and volunteers.
Conceptual foundation in
community-driven
sustainability.
Includes analytics modules to measure reductions
in food waste and carbon emissions.
Designed for scalability, allowing expansion to other regions and integration with additional services.
Technical execution using
Laravel, CSS, MySQL, and a
reliable server environment.
01 02
03 04
05Problem Description
Food waste poses
economic, social,
and environmental
issues.
Al-Jouf experiences
significant surplus food
waste despite community
needs.
Lack of structured
redistribution
mechanisms increases
disposal costs and
resource waste.
Logistical challenges, such
as transportation and
communication, hinder
efficient food sharing.
01
02 04
03Proposed Solution
A web-based platform connecting surplus food
providers with beneficiaries.
User-friendly interfaces and real-time matching
algorithms.
Delivery options include volunteer networks and
direct handovers.
Comprehensive data analytics to track food savings
and improve operations.
Promotes a culture of responsible consumption and
social solidarity.
01
02
03
04
05Proposed System Components
Backend
Server
Authentication,
donation and request
management,
matching algorithms,
and analytics.
Users
Responsive front-
end with real-time
notifications.
Web Interface Donors,
beneficiaries, and
volunteers with
role-specific
features
Database
Structured
storage for
user data,
transactions,
and reports.
01
02 03
04Proposed System Output
Real-time dashboards with
donation, request, and
transaction details.
Reports on reduced
carbon emissions and
landfill usage.
User feedback analysis to
enhance matching
algorithms and delivery
scheduling.
Evidence-based metrics
to support expansion and
partnership
opportunities.
01
03
02
04Main Features of the Proposed System
Food donation
and request
posting with
detailed
attributes.
Quality
verification, user
feedback, and
analytics
dashboards.
Community
engagement
through
sustainability tips
and impact
stories.
Real-time
matching of
donations with
requests.
Volunteer
coordination and
delivery task
management.
User registration,
profile
management, and
secure login.
01 02 03
04
05 06Requirements Gathering
Data gathered via a survey of 73
participants in Al-Jouf.
Majority of respondents
High digital
literacy and
daily internet
usage.
Strong interest
in surplus
food
redistribution
Identified key
challenges:
transportation,
delivery
responsibility,
and trust.
01 02 03Hardware Requirements:Software RequirementsFunctional Requirements
Core Functionalities for All Users Donor-Specific Functionalities
Beneficiary-Specific Functionalities. Volunteer-Specific Functionalities
Administrator-Specific Functionalities
Registration, authentication, profile management.
Real-time notifications and feedback submission. Post, manage, and track donations.
Create, update, and confirm requests View, accept, and track delivery tasks.
User management, system monitoring,
and analytics reporting.
01 02
0403
05Non-Functional Requirements
02
Performance and Reliability
High responsiveness, fault
tolerance, and robust backups
01
Usability and Security
Intuitive interfaces, secure
authentication, and data protection.
03
Maintainability and Scalability
High responsiveness, fault tolerance, and robust backupsUse Case
Diagram for
beneficiarySubmit Food Request
Manage Food Requests
Beneficiary Receive Real-Time Notifications
Transaction Confirmation
Send Feedback
Logout
Enter Request Details
<<Extend>>
Attach Special Notes
<<Extend>>
LoginRegister
Manage Profile
Validate
<<include>>
Load User Data
<<include>>
Forgot Password
<<Extend>>
<<include>>
Send Verification Code
<<include>>
Verify
Account
<<Extend>> Update Account Details
<<include>>
Change Password
<<Extend>>
Add Location Data
<<Extend>>Use Case
Diagram for
volunteerUse Case
Diagram
for donerDonor
LoginRegister
Manage Profile
Post Food Donation
Manage Donations
Validate
<<include>>
Load User Data
<<include>>
Forgot Password
<<Extend>>
<<include>>
Send Verification Code
<<include>>
Verify Account
<<Extend>>
Update Account Details
<<include>>
Change Password
<<Extend>>
Add Location Data
<<Extend>>
Upload Food Image
Enter Donation Details
Schedule Donation
<<include>>
<<include>>
<<Extend>>
Receive Real-Time Notifications
Logout
Transaction Confirmation
Send Feedback
<<include>> Confirm Delivery
Enter Feedback
Add Comment
<<include>>
<<Extend>>
Add Delete
Edite
<<Extend>> <<Extend>>
<<Extend>>Sequence
diagram for
donerSequence
diagram for
BeneficiarySequence
diagram for
volunteerSequence
diagram for
adminActivity diagram
for AdminActivity diagram
for volunteerActivity diagram
for DonerActivity diagram
for BeneficiaryClass DiagramER DiagramDatabase Diagram
Column
Name Data Type Key Type Description
id INT PK Unique identifier for
the user
name VARCHAR(100) Full name
email VARCHAR(100) UNIQUE Email address
password VARCHAR(255) Encrypted login
password
role ENUM
User type: donor,
beneficiary,
volunteer, admin
location VARCHAR(255) User's physical
location
Column Name Data Type Key Type Description
id INT PK Unique donation ID
donor_id INT FK Foreign key
referencing users(id)
food_type VARCHAR(100) Type of donated food
quantity INT Quantity of food
donated
expiration_date DATE Expiry date of the
food
pickup_time DATETIME Scheduled pickup
time
status ENUM Status: pending,
scheduled, deliveredData Dictionary
Field Name Data Type Null Allowed Key Type Description
id INT No PK Unique identifier for each
user
name VARCHAR(100) No Full name of the user
email VARCHAR(100) No UNIQUE Email address used for
login and communication
password VARCHAR(255) No Encrypted password
role ENUM No
User role: donor,
beneficiary, volunteer,
admin
location VARCHAR(255) Yes User's address or service
region
Field Name Data Type Null
Allowed Key Type Description
id INT No PK Unique ID for each
donation
donor_id INT No FK References the user who
made the donation
food_type VARCHAR(100) No Type of food item being
donated
quantity INT No Quantity available
expiration_date DATE Yes Expiry date of the donated
item (if applicable)
pickup_time DATETIME Yes Scheduled time for pickup
status ENUM No Donation status: pending,
scheduled, deliveredConclusion
This chapter explained the full design plan of the online food redistribution system. It used simple diagrams to
show how the system works in real life with different users like donors, beneficiaries, volunteers, and admins.
The diagrams showed how users interact, how task flow. They also explained each part to make building and
fixing the system easier.Future Work – FoodBridge Platform
Regional Expansion Opportunities
1. Expand the platform to other cities across Saudi Arabia
2. Regional customization (food regulations, logistics,
   outreach strategies)
3. Build partnerships with charities and local
   governments
   Mobile Application Development
1. Launch a dedicated app for Android and iOS
2. Push notifications for updates
3. GPS tracking for deliveries
4. Direct communication between donors, recipients, and volunteers
   Integration with Suppliers and Markets
1. Collaborate with restaurants, stores, and food
   suppliers
2. Use APIs to auto-post surplus from inventory systems
3. Streamline the donation process and increase food
   availability


FoodBridge Theme Colors
🌱 Primary Palette

Green (Main): #7DBA4C – eco-friendly, used for sustainability & growth.

Green (Dark): #2F7D32 – stronger shade, good for buttons & headers.

Beige Background: #F3F7E7 – light neutral background color.

🟠 Accent Colors

Orange (Carrot): #F89A3C – vibrant highlight, great for CTAs (Donate, Share buttons).

Yellow (Sun): #FDCB58 – secondary accent, good for icons or hover states.

🌍 Support Colors

Blue (Earth): #4A90E2 – friendly, trustful, can be used for links or secondary elements.

Brown (Hair/Tones): #8C5B3E – warm supportive tone, good for illustrations/icons.

⚪ Neutral Colors

White: #FFFFFF – for content background, cards.

Gray: #C9C9C9 – for borders, dividers, or muted text.

🖌 Suggested Website Use

Header/Footer: Dark Green #2F7D32 with white text.

Buttons/CTAs: Orange #F89A3C with white text, hover to darker shade.

Background: Beige #F3F7E7.

Highlights/Icons: Yellow #FDCB58, Blue #4A90E2.

Text: Mostly dark gray/black, with green for section headings.
