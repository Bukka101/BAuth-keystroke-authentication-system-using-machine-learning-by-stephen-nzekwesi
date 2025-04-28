# BAUTH

BAuth, a keystroke dynamics authentication system using machine learning

## Supervisor: Vivek Singh

# Project Vision
As cyber threats continue to escalate in both complexity and scale, traditional username-password authentication mechanisms have proven increasingly insufficient in safeguarding sensitive information. The rise of large-scale password breaches, brute-force attacks, and credential stuffing has exposed the inherent vulnerabilities of static, knowledge-based authentication systems. These developments have necessitated a shift towards more robust and layered security models.<br>
Multi-Factor Authentication (MFA) has emerged as a widely adopted solution. Common MFA implementations include one-time passwords (OTPs), hardware tokens, email verifications, and biometric authentication. While these methods significantly increase security, they often come with trade-offs. Many rely on external devices—such as smartphones, hardware tokens, or specialized biometric scanners—which can introduce logistical, financial, and accessibility challenges, particularly in large-scale or resource-constrained environments.<br>
BAuth is an intelligent authentication system that leverages machine learning to analyse and learn from users’ unique keystroke dynamics – such as typing speed and rhythm – as a foundation for identity verification. Unlike conventional multi-factor authentication (MFA) approaches that depend on external devices, BAuth operates independently by relying solely on the user's keyboard interactions. This eliminates the need for additional hardware, offering a seamless, cost-effective, and device-free authentication experience.<br>
By leveraging typing patterns that are difficult to forge, BAuth enhances security without compromising user experience. The system continuously adapts to users’ natural typing variations, ensuring robust and real-time authentication. This approach not only strengthens access control but also offers a scalable, cost-effective solution for organizations aiming to protect digital assets in an increasingly hostile cyber environment.


## Keywords
BAuth, Keystroke Dynamics, Behavioural Authentication, Keystroke Authentication, Machine learning 

## Directory/Files Definition
 - BAuth directory contains the web interface codes and files for the system's web interface. This includes the Controller/control.php - which contains the php code for frontend manipulation; Model/function.php - which contains the code for database manipulation; and View/ - which contains the frontend code files and assets.
 - Dataset directory contains the dataset files. The keystroke.csv file is the complete dataset (Benchmark dataset from Kaggle). This was shuffled and splitted into two, to create train_data.csv and test_data.csv. With train_data meant to be used for model training, and records from test_data to be used for system testing.
 - Docs directory contains the project documentation, including the poster files and final report.
 - Python_scripts directory contains the python files both in ipynb and py formats. The bauth_app defines the routes and starts Flask, while bauth_functions defines the training and classification functionalities.
 - keystrole.sql file contains the sql to define and populate the system's database.
 - requirements.txt file contains the python dependencies required to effectively run the python code.
 - sample_test_json.docx contains some sample data for product testing. This includes username, password, and keystroke data of some users in the system's database. This was created for convenience, so that they can be easily copied and pasted when testing the system, saving the hassle of typing the keystroke json from scratch.


## Setup Instructions
Python, PHP, and MySql are required for the system to run. Make sure they are installed and configured correctly.
 - Download and install Python from [python official website](https://www.python.org/downloads/) 
 
PHP and MySQL comes together with XAMPP, a free and open-source cross-platform web server solution.
 - [Download](https://www.apachefriends.org/download.html) and install XAMPP.
 - Copy BAuth directory to XAMPP’s htdocs directory on your local machine.

Moving forward, required python dependencies are listed in requirements.txt file. To install, run command `pip install -r requirements.txt` on your device terminal. 


## To Run
Flask is the python library that provides the API for the model training and classification. To run Flask, navigate to the directory that contains the python files (Python_scripts) in terminal or command line. Then run the command `python bauth_app.py` or `python3 bauth_app.py` to execute. <br>
[Output:  `Running on http://127.0.0.1:5000/`] <br>

With Flask running,
 - Start XAMPP and run servers.
 - Open http://localhost/phpmyadmin/ on your browser, and create a new database with the name “bauth”. Then import keystroke.sql into the newly created database to populate the database with required tables and data.
 - Open http://localhost/bauth/ on your browser to access the BAuth system.


## API
The API run independently of the web interface. With Flask running, you can make a POST api call request to http://127.0.0.1:5000/train to train a model, supplying inputs such as - model_name(string), model_type('RF' or 'SVM'), and dataset(cvs file). <br>
The process saves model files (model.joblib and scaler. joblib) to your local machine at [home]/BAuth/model_files/. <br>
Note that the dataset must be formatted appropriately for effective model training. The dataset definition and format is contained in the appendix section (16.4.) of the project report. [Use Dataset/train_data.csv to train models]

To make a prediction, make a POST request to http://127.0.0.1:/5000/predict, supplying a JSON object containing model name and keystroke data. The JSON object definition and format is contained in appendix section (16.4.) of the project report. [For convenience, some sample test data are contained in sample_test_json.docx]<br>
The prediction returns user ID of the predicted user.
