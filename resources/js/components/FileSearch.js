import React, {Component} from 'react';
import axios from 'axios';
import debounce from 'debounce-promise';
import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';

import {baseURL} from '../config';
import {replaceFiles} from '../actions';

class FileSearch extends Component {
    constructor(props) {
        super(props);
        this.state = {
            fileName: '',
            fileType: ''
        };
    }

    handleFileNameChange(e) {
        const newState = {fileName: e.target.value};
        this.setState(newState);
        debounce(this.performSearch({...this.state, ...newState}), 500);
    }

    handleFileTypeChange(e) {
        const newState = {fileType: e.target.value};
        this.setState(newState);
        debounce(this.performSearch({...this.state, ...newState}), 500);
    }

    performSearch(args) {
        return axios.get(baseURL + '/api/file', {
            params: {
                search: args.fileName,
                type: args.fileType
            }
        }).then(res => this.props.actions.replaceFiles(res.data));
    }

    render() {
        return (
            <div className="flex-container flex-horizontal flex-between">
                <input className="search-input" placeholder="Search for file names" type="text"
                       onChange={this.handleFileNameChange.bind(this)} value={this.state.fileName}/>
                <input className="search-input" placeholder="Search for file types" type="text"
                       onChange={this.handleFileTypeChange.bind(this)} value={this.state.fileType}/>
            </div>
        );
    }
}

const mapDispatchToProps = dispatch => ({
    actions: bindActionCreators({
        replaceFiles
    }, dispatch)
});

export default connect(null, mapDispatchToProps)(FileSearch);