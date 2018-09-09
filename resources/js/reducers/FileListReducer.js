import {ADD_FILES, UPDATE_FILE_UPLOAD_PROGRESS, DELETE_FILE, REPLACE_FILES} from '../action-types';

const initialState = {
    files: []
};

const initialFileState = {
    fileID: null,
    fileName: '',
    url: '',
    uploadProgressPercent: 0,
    uploadComplete: false,
};

const FileListReducer = (state = initialState, action) => {
    if (action.type === ADD_FILES) {
        return {...state, files: [...state.files, ...action.payload.map(file => ({...initialFileState, ...file}))]};
    } else if (action.type === UPDATE_FILE_UPLOAD_PROGRESS) {
        return {
            ...state,
            files: state.files.map(file => {
                if (file.fileID == action.payload.fileID) {
                    return {
                        ...file,
                        uploadProgressPercent: action.payload.progressPercent,
                        uploadComplete: action.payload.progressPercent >= 100
                    };
                }

                return file;
            })
        }
    } else if (action.type === DELETE_FILE) {
        return {
            ...state,
            files: state.files.filter(file => file.fileID !== action.payload.fileID)
        }
    } else if (action.type === REPLACE_FILES) {
        return {
            ...state,
            files: [...action.payload.map(file => ({
                ...initialFileState,
                fileID: file.id,
                fileName: file.filename,
                url: file.url,
                uploadComplete: true
            }))]
        };
    }

    return state;
};

export default FileListReducer;
