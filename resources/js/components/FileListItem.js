import React, {Component} from 'react';
import {Circle} from 'rc-progress';
import axios from 'axios';
import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';

import {deleteFile} from '../actions';
import {baseURL} from '../config';

class FileListItem extends Component {
    deleteFile() {
        return axios.delete(baseURL + '/api/file/' + this.props.file.fileID)
            .then(res => this.props.actions.deleteFile(this.props.file.fileID));
    }

    render() {
        return (
            <li>
                {this.props.file.uploadComplete
                    ? <a href={this.props.file.url} target="_blank">{this.props.file.fileName}</a>
                    : <span>{this.props.file.fileName}</span>}
                {!this.props.file.uploadComplete
                    ? <Circle percent={this.props.file.uploadProgressPercent} strokeWidth={3}/>
                    : null}
                {this.props.file.uploadComplete
                    ? <button onClick={this.deleteFile.bind(this)}>Delete</button>
                    : null}
            </li>
        );
    }
}

const mapDispatchToProps = dispatch => ({
    actions: bindActionCreators({
        deleteFile
    }, dispatch)
});

export default connect(null, mapDispatchToProps)(FileListItem);