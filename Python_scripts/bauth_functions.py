# Importation
import pandas as pd
from sklearn.preprocessing import MinMaxScaler
from sklearn.ensemble import RandomForestClassifier
from sklearn.svm import SVC
import joblib

# Process dataset
# input: dataset
# output: normalized dataframe ready for model training

def process_dataset(dataset):
    # Read the dataset
    dt = pd.read_csv(dataset)

    # Verify the cvs file has the titles requires for model training
    cvs_title = list(dt.columns)
    expected_title = ['subject', 'H.period', 'DD.period.t', 'UD.period.t', 'H.t', 'DD.t.i', 'UD.t.i', 'H.i', 'DD.i.e', 'UD.i.e', 'H.e', 'DD.e.five', 'UD.e.five', 'H.five', 'DD.five.Shift.r', 'UD.five.Shift.r', 'H.Shift.r', 'DD.Shift.r.o', 'UD.Shift.r.o', 'H.o', 'DD.o.a', 'UD.o.a', 'H.a', 'DD.a.n', 'UD.a.n', 'H.n', 'DD.n.l', 'UD.n.l', 'H.l', 'DD.l.Return', 'UD.l.Return', 'H.Return']

    for item in expected_title:
        if item not in cvs_title:
            raise Exception ("The CVS file is not as expected!")

    # Drop subject column
    df = dt[expected_title]
    df = df.drop(columns=['subject'])

    # Calculate row-based mean, variance, and standard deviation
    row_means = df.mean(axis=1)
    row_variances = df.var(axis=1)
    row_std_devs = df.std(axis=1)

    # Add the calculated values as new columns to the DataFrame
    df['row_mean'] = row_means
    df['row_variance'] = row_variances
    df['row_std_dev'] = row_std_devs

    ## Normalize dataframe
    scaler = MinMaxScaler()
    df_normalized = pd.DataFrame(scaler.fit_transform(df), columns=df.columns)

    # Add subject column
    df_normalized['subject'] = dt['subject']

    return df_normalized



# split training features and target
# input: normalized dataframe;
# output: X (training features), y (target)

def split_df(df):
    X = df.drop(columns=['subject'])
    y = df['subject'].values

    return X, y

# Random forest model
# input: training features (X), target (y)
# output: trained random forest model

def rf_model(X, y):
    rf_classifier = RandomForestClassifier()
    rf_classifier.fit(X, y)

    return rf_classifier

# SVC model
# input: training features (X), target (y)
# output: trained SVC model

def svm_model(X, y):
    svm_model = SVC()
    svm_model.fit(X, y)


# Run code and save model to disk
# input: model name (str), dataset (csv), model type ('RF' or 'SVM'), system location to save model (str)
# output: 1 if sucessfull

def run_train(model_name, dataset, model_type, path):
    # Inspect inputs
    m_name, m_dataset, m_type, m_path = model_name, dataset, model_type, path

    # Process dataset
    df = process_dataset(m_dataset)

    # Split dataframe into features and target
    X, y = split_df(df)

    # Train model
    if m_type == "RF":
        model = rf_model(X, y)
    elif m_type == "SVM":
        model = svm_model(X, y)

    full_path = m_path + m_name + ".joblib"
    joblib.dump(model, full_path)

    return 1