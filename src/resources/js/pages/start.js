import React from 'react';
import ValidationErrors from '@/components/validationerrors';
import { Head, useForm } from '@inertiajs/inertia-react';
import Div100vh from 'react-div-100vh';

export default function Start(props) {

  const { data, setData, post, processing, errors, reset } = useForm({
    group_id: '',
    name: '',
  });

  const handleChange = (event) => {
    setData(event.target.name, event.target.value);
  };

  const submit = (e) => {
    e.preventDefault();
    post(route('create-team'));
  };

  return (
    <>
      <Head title="Create a team" />
      <Div100vh className="flex items-center bg-slate-900 px-8">
        <div className="p-5 bg-white rounded-xl shadow-lg w-full">
          <div className="mb-2">
            <h1 className="block mb-2 font-serif text-3xl text-purple-800">Heritage Trail</h1>
            <p>Pick your Scout Group and decide on a team name to start the trail</p>
          </div>

          <ValidationErrors errors={errors} />

          <form onSubmit={submit}>
            <div className="space-y-4">
              <div>
                <label htmlFor="group" className="block font-medium text-sm text-slate-700">Scout Group</label>
                <div className="flex flex-col items-start">
                  <select
                    name="group"
                    className="border-slate-300 focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                    required="required"
                    defaultValue="-"
                    onChange={(e) => handleChange(e)}
                  >
                    <option key="-" value="-" disabled>Select your Group</option>
                    {props.groups.map(g => (<option key={g.id} value={g.id}>{g.name}</option>))}
                  </select>
                </div>
              </div>

              <div>
                <label htmlFor="name" className="block font-medium text-sm text-slate-700">Team Name</label>
                <div className="flex flex-col items-start">
                  <input
                    type="text"
                    name="name"
                    className="border-slate-300 focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                    required="required"
                    placeholder="Pick a team name"
                    onChange={(e) => handleChange(e)}
                  />
                </div>
              </div>

              <div>
                <button
                  type="submit"
                  className={`inline-flex items-center px-4 py-2 bg-purple-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest active:bg-purple-900 transition ease-in-out duration-150 ${processing && 'opacity-25'}`}
                  disabled={processing}
                >
                  Start trail
                </button>
              </div>
            </div>
          </form>
        </div>
      </Div100vh>
    </>
  );
}
