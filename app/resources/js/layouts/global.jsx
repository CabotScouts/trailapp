import { usePage } from '@inertiajs/react';
import { router } from '@inertiajs/react'
import toast, { Toaster } from 'react-hot-toast';

import { __, } from '@/composables/translations';

export default function Global(children) {

  const partialReload = (type) => {
    if (type === "answer") {
      router.reload({ only: ['points', 'questions', 'submission'] })
    }
    else {
      router.reload({ only: ['points', 'challenges', 'submission'] })
    }
  }

  const strings = usePage().props.translations;

  const submissionAccepted = (submission) => {
    toast.success(
      <div>
        {__("submission_accepted", {
          "type": __(submission.type, {}, strings),
          "submission": <span className="font-bold">{submission.name}</span>
        }, strings)}
      </div>
    );
  }

  const submissionRejected = (submission) => {
    toast.error(
      <div>
        {__("submission_rejected", {
          "type": __(submission.type, {}, strings),
          "submission": (<span className="font-bold">{submission.name}</span>)
        }, strings)
        }
      </div>
    );
  }

  const displayMessage = (message) => {
    toast.custom((t) => (
      <div className="p-5 bg-white rounded-xl shadow-lg w-full">
        <p className="font-serif text-2xl font-bold text-purple-900">{__("A message from Trail HQ!")}</p>
        <p className="text-lg py-4">{message.message}</p>
        <button
          onClick={() => toast.remove(t.id)}
          className="inline-flex items-center px-4 py-2 bg-purple-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest"
        >
          {__("OK!")}
        </button>
      </div>
    ),
      {
        duration: Infinity,
      });
  }

  if (window.TeamListener === undefined) {
    window.TeamListener = window.Echo.private(`team.${usePage().props.auth.user.id}`)
      .listen('SubmissionReceived', (submission) => {
        partialReload(submission.type);
      })
      .listen('SubmissionAccepted', (submission) => {
        submissionAccepted(submission);
        partialReload(submission.type);
      })
      .listen('SubmissionRejected', (submission) => {
        submissionRejected(submission);
        partialReload(submission.type);
      }).listen('MessageToTeams', (message) => displayMessage(message));
  }

  if (window.MessageListener === undefined) {
    window.MessageListener = window.Echo.channel('global').listen('MessageToTeams', (message) => displayMessage(message));
  }

  return (
    <>
      <Toaster />
      {children.children}
    </>
  );
}
