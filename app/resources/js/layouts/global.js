import React, { useEffect } from 'react';
import { Inertia } from '@inertiajs/inertia'
import toast, { Toaster } from 'react-hot-toast';

export default function Global(children) {
  
  const partialReload = (type) => {
    if(type === "answer") {
      Inertia.reload({ only: ['questions', 'submission'] })
    }
    else {
      Inertia.reload({ only: ['challenges', 'submission'] })
    }
  }
  
  const displayMessage = (message) => {
    toast.custom((t) => (
      <div className="p-5 bg-white rounded-xl shadow-lg w-full">
        <p className="font-serif text-2xl font-bold text-purple-900">A message from Trail HQ!</p>
        <p className="text-lg py-4">{ message.message }</p>
        <button
          onClick={ () => toast.remove(t.id) }
          className="inline-flex items-center px-4 py-2 bg-purple-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest"
        >
          OK!
        </button>
      </div>
    ),
    {
      duration: Infinity,
    });
  }
  
  if(window.TeamListener === undefined) {
    window.TeamListener = window.Echo.private(`team.${children.props.auth.user.id}`)
    .listen('SubmissionReceived', (submission) => {
      partialReload(submission.type);
    })
    .listen('SubmissionAccepted', (submission) => {
      toast.success(<div>Your { submission.type } for <span className="font-bold">{ submission.name }</span> was accepted! 🥳</div>);
      partialReload(submission.type);
    })
    .listen('SubmissionRejected', (submission) => {
      toast.error(<div>Your { submission.type } for <span className="font-bold">{ submission.name }</span> was rejected 😬</div>);
      partialReload(submission.type);
    }).listen('MessageToTeams', (message) => displayMessage(message));
  }
  
  if(window.MessageListener === undefined) {
    window.MessageListener = window.Echo.channel('global').listen('MessageToTeams', (message) => displayMessage(message));
  }
  
  return (
    <>
      <Toaster />
      { children }
    </>
  );
}
