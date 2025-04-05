# BAUTH

BhAuth, a keystroke dynamics authentication system using machine learning

## Supervisor: Vivek Singh

# Project Vision
As cyber threats continue to evolve, traditional username and password authentication methods are increasingly becoming vulnerable to security breaches. Weak password management, phishing attacks, and large-scale data breaches have made conventional authentication methods highly susceptible to exploitation. Attackers continuously develop new techniques to bypass security barriers, compromising sensitive data and user accounts. 
To counter unauthorised access and strengthen cybersecurity measures, organisations must adopt more advanced authentication mechanisms that go beyond static credentials. One such approach is Multi-Factor Authentication (MFA), which adds additional verification layers to ensure user legitimacy. While many organisations incorporate one-time passwords (OTPs) or security tokens as secondary factors, behavioural authentication offers a unique and more reliable alternative.
BAuth is an advanced authentication system that leverages machine learning to integrate keystroke dynamics as an additional security layer, reinforcing traditional username-password authentication. Unlike traditional methods that rely solely on static credentials, BAuth verifies user identity based on unique typing patterns, such as typing speed and rhythm. This ensures that access is granted only to the legitimate user, even if their credentials are compromised.
By incorporating behavioural authentication, BAuth enhances security while maintaining a seamless user experience. Effectively, BAuth does not require any specialised hardware, making it cost-effective, scalable, and easy to integrate into existing security frameworks. 
As cybercriminals continue to refine their attack strategies, businesses and individuals must stay ahead by adopting more adaptive and intelligence-driven authentication solutions. Behavioural authentication, powered by machine learning, offers a proactive security approach by monitoring and validating users based on their unique interactions with systems.
BAuth exemplifies the potential of behavioural authentication, ensuring first-hand identity verification and minimising risks associated with credential theft. By embracing such innovative security measures, organisations can significantly enhance their cybersecurity posture, protecting sensitive data while maintaining user convenience.


## Keywords
BAuth, Keystroke Dynamics, Behavioural Authentication, Keystroke Authentication, Machine learning 


## Setup Instructions
Python, PHP, and MySql are required for this project. Make sure they are installed and configured correctly.
 - Download and install Python from [python official website](https://www.python.org/downloads/)
 - Download and install [PHP](https://www.php.net/downloads.php) 
 - Download, install and set up MySql from the [official website](https://www.mysql.com/downloads/)
 - Install/configure php-mysql extension, required to use MySql with PHP. 

Instructions on how to do these, depending on your particular operating system are publicly available online.

Moving forward, required python dependencies are listed in requirements.txt. To install, run command
`pip install -r requirements.txt`

## Run
Flask is the python library that provides the api for the model training and execution. To run flask, navigate to the directory that contains the python files (Python_scripts) in terminal or command prompt. Then run the command `python bauth_app.py` to execute. <br>
Output:  `Running on http://127.0.0.1:5000/` <br>
Open http://127.0.0.1:5000/ in your browser. <br>
By default, Flask runs on port 5000, but you can change which port you wish using the command: `flask run --port=<Port_number>` 

With flask running, you can make api POST call to http://127.0.0.1:5000/train to train model. supplying inputs - model_name(string), model_type(string), path (string representing system path to directory. Must end with forward or backward slash), dataset(cvs file).

To make a prediction, POST request http://127.0.0.1:/5000/predict, supplying model path on disk and keystroke data, in a JSON object. 
