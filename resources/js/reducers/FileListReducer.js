import {ADD_FILES, UPDATE_FILE_UPLOAD_PROGRESS} from '../action-types';

const initialState = {
    files: []
};

const FileListReducer = (state = initialState, action) => {
    if (action.type === ADD_FILES) {
        return {...state, files: [...state.files, ...action.payload]};
    } else if (action.type === UPDATE_FILE_UPLOAD_PROGRESS) {
        return {
            ...state,
            files: state.files.map(file => {
                if (file.fileID == action.payload.fileID) {
                    return {
                        ...file,
                        uploadProgressPercent: action.payload.progressPercent
                    };
                }

                return file;
            })
        }
    }

    return state;
};

export default FileListReducer;
