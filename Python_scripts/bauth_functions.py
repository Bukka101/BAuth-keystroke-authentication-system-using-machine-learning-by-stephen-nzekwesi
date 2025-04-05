#!/usr/bin/env python
# coding: utf-8

# In[ ]:


# Importation
import pandas as pd
from sklearn.preprocessing import MinMaxScaler
from sklearn.ensemble import RandomForestClassifier
from sklearn.svm import SVC
import joblib
import statistics


# In[ ]:


# Process dataset - engineer features and normalize dataset
# input: dataset
# output: normalized dataframe

def process_dataset(dataset):
    # Read the dataset
    dt = pd.read_csv(dataset)

    # Verify the cvs file has the titles requires for model training
    cvs_title = list(dt.columns)
    expected_title = ['subject', 'H.period', 'DD.period.t', 'UD.period.t', 'H.t', 'DD.t.i', 'UD.t.i', 'H.i', 'DD.i.e', 'UD.i.e', 'H.e', 'DD.e.five', 'UD.e.five', 'H.five', 'DD.five.Shift.r', 'UD.five.Shift.r', 'H.Shift.r', 'DD.Shift.r.o', 'UD.Shift.r.o', 'H.o', 'DD.o.a', 'UD.o.a', 'H.a', 'DD.a.n', 'UD.a.n', 'H.n', 'DD.n.l', 'UD.n.l', 'H.l', 'DD.l.Return', 'UD.l.Return', 'H.Return']

    for item in expected_title:
        if item not in cvs_title:
            raise Exception ("The CVS file is not formated as expected!")


    """ engineer features
    Drop subject column
    Calculate row-based mean, variance, and standard deviation
    Add the calculated values as new columns to the DataFrame
    Normalize dataframe
    Add subject column
    return normalized dataframe
    """
    df = dt[expected_title]
    df = df.drop(columns=['subject'])

    row_means = df.mean(axis=1)
    row_variances = df.var(axis=1)
    row_std_devs = df.std(axis=1)

    df['row_mean'] = row_means
    df['row_variance'] = row_variances
    df['row_std_dev'] = row_std_devs

    scaler = MinMaxScaler()
    df_normalized = pd.DataFrame(scaler.fit_transform(df), columns=df.columns)

    df_normalized['subject'] = dt['subject']

    return df_normalized, scaler



# In[ ]:


# split training features and target
# input: normalized dataframe;
# output: X (training features), y (target)

def split_df(df):
    X = df.drop(columns=['subject'])
    y = df['subject'].values

    return X, y


# In[ ]:


# train Random forest model
# input: training features (X), target (y)
# output: trained random forest model

def rf_model(X, y):
    rf_classifier = RandomForestClassifier()
    rf_classifier.fit(X, y)

    return rf_classifier


# In[ ]:


# train SVC model
# input: training features (X), target (y)
# output: trained SVC model

def svm_model(X, y):
    svm_model = SVC()
    svm_model.fit(X, y)

    return svm_model


# In[ ]:


# train model - save model files to disk
# input: model name (str), dataset (csv), model type ('RF' or 'SVM'), system location to save model (str)
# output: 1 on success

def run_train(model_name, dataset, model_type, path):
    """Inspect inputs
    Process dataset
    Split dataframe into features and target
    Train model
    dump model files to disk
    """
    m_name, m_dataset, m_type, m_path = model_name, dataset, model_type, path

    df, scaler = process_dataset(m_dataset)

    X, y = split_df(df)

    if m_type == "RF":
        model = rf_model(X, y)
    elif m_type == "SVM":
        model = svm_model(X, y)

    m_full_path = m_path + m_name + ".joblib"
    s_full_path = m_path + m_name + "_scaler" +".joblib"
    joblib.dump(model, m_full_path)
    joblib.dump(scaler, s_full_path)

    return 1


# In[ ]:


# Process prediction input data -
# Confirm input has expected keys needed for prediction
# Process and scale data using model scaler
# Predict user using specified model
# Input: model_path (absolute path of the model on disk), keystroke (dictionary of user's keystroke data)
# Output: predicted user ID

def run_pred(keystroke):
    m_path = keystroke['model_path']
    del keystroke['model_path']
    expected_keys = ['H.period', 'DD.period.t', 'UD.period.t', 'H.t', 'DD.t.i', 'UD.t.i', 'H.i', 'DD.i.e', 'UD.i.e', 'H.e', 'DD.e.five', 'UD.e.five', 'H.five', 'DD.five.Shift.r', 'UD.five.Shift.r', 'H.Shift.r', 'DD.Shift.r.o', 'UD.Shift.r.o', 'H.o', 'DD.o.a', 'UD.o.a', 'H.a', 'DD.a.n', 'UD.a.n', 'H.n', 'DD.n.l', 'UD.n.l', 'H.l', 'DD.l.Return', 'UD.l.Return', 'H.Return']

    if list(keystroke.keys()) == expected_keys:

        ks_values = list(keystroke.values())
        # Compute statistics
        mean_value = statistics.mean(ks_values)
        variance_value = statistics.variance(ks_values)
        std_dev_value = statistics.stdev(ks_values)

        # Add to dictionary
        keystroke["row_mean"] = mean_value
        keystroke["row_variance"] = variance_value
        keystroke["row_std_dev"] = std_dev_value

        # Load model and scaler from disk, scale and make prediction.
        # Return prediction
        try:
            model = joblib.load(m_path)
            scaler = joblib.load(m_path.replace(".joblib", "_scaler.joblib"))

            keystroke = pd.DataFrame(keystroke, index=[0])

            df_norm = scaler.transform(keystroke)

            model_pred = model.predict(df_norm)

            return model_pred[0]

        except Exception as e:
            return ("Error! Model loading and prediction unsuccessful. Make sure the trained model files are in the specified directory")

    else:
        raise Exception ("Keystroke data does not have required keys for model prediction!")

