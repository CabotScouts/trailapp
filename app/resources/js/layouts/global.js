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
  
  if(window.TeamListener === undefined) {
    window.TeamListener = window.Echo.private(`team.${children.props.auth.user.id}`)
    .listen('SubmissionAccepted', (submission) => {
      toast.success(<div>Your { submission.type } for <span className="font-bold">{ submission.name }</span> was accepted! 🥳</div>);
      partialReload(submission.type);
    })
    .listen('SubmissionRejected', (submission) => {
      toast.error(<div>Your { submission.type } for <span className="font-bold">{ submission.name }</span> was rejected 😬</div>);
      partialReload(submission.type);
    });
  }
  
  if(window.MessageListener === undefined) {
    window.MessageListener = window.Echo.channel('global').listen('MessageToTeams', (message) => { 
      toast(
        <div className="flex flex-col">
          <p className="text-lg font-bold pb-2">A message from trail HQ</p>
          <p>{message.message}</p>
        </div>, {
        icon: '📢',
        duration: 20000,
      });
    });
  }
  
  return (
    <>
      <Toaster />
      { children }
    </>
  );
}
