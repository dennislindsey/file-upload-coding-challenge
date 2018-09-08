import React, {Component} from 'react';
import { render } from 'react-dom';
import { Provider } from 'react-redux';

import store from '../store';

import FileUploader from './FileUploader';
import FileList from './FileList';

export default class Main extends Component {
    render() {
        return (
            <div className="flex-container">
                <FileUploader />
                <FileList />
            </div>
        );
    }
}

if (document.getElementById('main')) {
    render(
        <Provider store={store}>
            <Main />
        </Provider>,
        document.getElementById('main')
    );
}
