import React, {Component} from 'react';
import {render} from 'react-dom';
import {Provider} from 'react-redux';
import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';

import store from '../store';
import {initApp} from '../actions';

import FileUploader from './FileUploader';
import FileList from './FileList';

class Main extends Component {
    componentDidMount() {
        this.props.actions.initApp();
    }

    render() {
        return (
            <div className="flex-container">
                <FileUploader />
                <FileList />
            </div>
        );
    }
}

const mapDispatchToProps = dispatch => ({
    actions: bindActionCreators({
        initApp
    }, dispatch)
});

const App = connect(null, mapDispatchToProps)(Main);

if (document.getElementById('main')) {
    render(
        <Provider store={store}>
            <App />
        </Provider>,
        document.getElementById('main')
    );
}
