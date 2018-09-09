import React, {Component} from 'react';
import Dropzone from 'react-dropzone'
import axios from 'axios';
import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';

import {baseURL} from '../config';
import {addFiles, updateFileUploadProgress} from '../actions';

class FileUploader extends Component {
    uploadChunk(fileID, fileName, endOfFile, chunk) {
        return axios.patch(baseURL + '/api/file/' + fileID, {
            endOfFile,
            chunk
        });
    }

    createNewFile(file) {
        return axios.post(baseURL + '/api/file', {
            fileName: file.name
        });
    }

    onDrop(acceptedFiles, rejectedFiles) {
        acceptedFiles.forEach(file => this.createNewFile(file)
            .then(res => {
                const reader = new FileReader();
                const chunkSize = 1024 * 1024;
                let offset = 0;

                reader.onloadend = e => {
                    if (e.target.readyState != FileReader.DONE) {
                        return;
                    }

                    offset += chunkSize;

                    this.uploadChunk(file.fileID, file.filename, offset >= file.file.size, window.btoa(e.target.result))
                        .then(res => {
                            this.props.actions.updateFileUploadProgress(file.fileID, Math.min(parseInt(offset / file.file.size * 100), 100))
                            if (offset < file.file.size) {
                                reader.readAsBinaryString(file.file.slice(offset, Math.min(offset + chunkSize, file.file.size)));
                            }
                        });
                };
                reader.onabort = () => console.log('file reading was aborted');
                reader.onerror = () => console.log('file reading has failed');

                file = {
                    fileID: res.data.id,
                    fileName: res.data.filename,
                    url: res.data.url,
                    uploadProgressPercent: 0,
                    uploadComplete: false,
                    file
                };
                this.props.actions.addFiles([file]);
                reader.readAsBinaryString(file.file.slice(offset, Math.min(offset + chunkSize, file.file.size)));
            })
        );
    }

    render() {
        let dropzoneRef;

        return (
            <div className="card">
                <Dropzone className="dropzone" onDrop={this.onDrop.bind(this)} ref={node => dropzoneRef = node}>
                    <p>Drop files here or click to upload.</p>
                </Dropzone>
            </div>
        );
    }
}

const mapDispatchToProps = dispatch => ({
    actions: bindActionCreators({
        addFiles,
        updateFileUploadProgress
    }, dispatch)
});

export default connect(null, mapDispatchToProps)(FileUploader);