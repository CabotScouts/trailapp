import React from 'react';
import { Head, useForm } from '@inertiajs/inertia-react';
import { Modal, Header } from '@/layouts/modal';
import Errors from '@/components/form/errors';
import TextSubmission from '@/components/text-submission';


export default function Question({ question, submission }) {
  const { data, setData, post, processing, errors } = useForm({
    question: question.id,
    answer: submission.answer || '',
  });

  const handleChange = (e) => {
    setData(e.target.name, e.target.value);
  }

  const submit = (e) => {
    e.preventDefault();
    post(route('submit-question', question.id));
  }

  return (
    <>
      <Head title={question.name} />
      <Modal back={route('trail')}>
        <Header data={question} />
        <div className="px-10">
          {Object.keys(errors).length > 0 &&
            <div className="mb-5 p-4 bg-white rounded-xl shadow-lg">
              <Errors errors={errors} />
            </div>
          }

          {(submission.accepted == false) &&
            <form onSubmit={submit}>
              <textarea
                name="answer"
                value={data.answer}
                rows="5"
                className="border-slate-300 focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                required
                placeholder="Enter your answer..."
                onChange={(e) => handleChange(e)}
              />
              <button
                type="submit"
                className={`inline-flex items-center px-4 py-2 mt-2 bg-white border border-transparent rounded-md
                font-semibold text-xs text-purple-900 uppercase tracking-widest active:bg-white transition ease-in-out duration-150 ${processing && 'opacity-25'}`}
                disabled={processing}
              >
                {(submission.answer == false) && 'Submit'}{(submission.answer != false) && 'Update'} answer
              </button>
            </form>
          }
          {(submission.accepted == true) && <TextSubmission submission={submission.answer} />}
        </div>
      </Modal>
    </>
  );
}
